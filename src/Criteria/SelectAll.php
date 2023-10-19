<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Database\Query\Expression;

class SelectAll implements Criteria {
	/**
	 * @var array
	 */
	protected array $columns;

	/**
	 * @var bool
	 */
	protected bool $withRootAlias;

	/**
	 * SelectAll constructor.
	 *
	 * @param  array $columns
	 * @param  bool $withRootAlias
	 */
	public function __construct(array $columns = [], bool $withRootAlias = true) {
		$this->columns = $columns;
		$this->withRootAlias = $withRootAlias;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return array
	 */
	protected function mapColumns($builder): array {
		return array_map(
			fn($column) => $this->withRootAlias && !($column instanceof Expression) ? $builder->queryColumn($column) : $column,

			($this->columns ?: ['*'])
		);
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		return $builder->select($this->mapColumns($builder));
	}
}
