<?php

namespace IhorOk\QueryCriteria\Helpers;

use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait HasSpecificSort {
	use HasJoins;

	/**
	 * @param  string|null $column
	 *
	 * @return array
	 */
	abstract protected function specificColumns(?string $column = null): array;

	/**
	 * @return string
	 */
	abstract protected function getSpecificColumn(): string;

	/**
	 * @return array
	 */
	public function joins(): array {
		$joinFields = $this->specificColumns($this->getSpecificColumn());

		$tbName = Arr::get($joinFields, 0);
		$firstColumn = Arr::get($joinFields, 1);
		$secondColumn = Arr::get($joinFields, 2);
		$withAlias = Arr::get($joinFields, 'withAlias', false);

		$pivotTables = Arr::get($joinFields, 'pivot', []);

		$pivotJoins = [];
		foreach ($pivotTables as $pivot) {
			$table = Arr::get($pivot, 'table');

			$pivotJoins[$table] = function ($builder) use ($table, $pivot) {
				/* @var IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder */

				$first = Arr::get($pivot, 'first');
				$second = Arr::get($pivot, 'second');
				$secondWithAlias = Arr::get($pivot, 'secondWithAlias', false);

				return $builder->join($table, $first, '=', ($secondWithAlias ? $builder->queryColumn($second) : $second));
			};
		}

		$joins = [
			$tbName => function ($builder) use ($tbName, $firstColumn, $secondColumn, $withAlias) {
				/* @var IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder */

				return $builder->join(
					$tbName,
					"{$tbName}.{$firstColumn}", '=', ($withAlias ? $builder->queryColumn($secondColumn) : $secondColumn)
				);
			},
		];

		return array_merge($pivotJoins, $joins);
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 * @param  array $joinFields
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function applySpecificSort($builder, array $joinFields) {
		$this->applyJoins($builder);

		$tbName = Arr::get($joinFields, 0);
		$orderColumn = Arr::get($joinFields, 3, $this->column);

		$groupBy = Arr::wrap(Arr::get($joinFields, 'groupBy', []));

		$joins = $this->resultJoins();

		if ($groupBy && $joins) {
			DB::statement("set sql_mode='';");

			$builder->groupBy(array_map(fn ($column) => $builder->queryColumn($column), $groupBy));
		}

		return $builder->orderBy("{$tbName}.{$orderColumn}", $this->strategy);
	}
}
