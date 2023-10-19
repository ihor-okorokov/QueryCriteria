<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use IhorOk\QueryCriteria\Support\Arr;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class Where implements Criteria {
	/**
	 * @var array $values
	 */
	public array $values;

	/**
	 * @var string
	 */
	protected string $column = 'id';

	/**
	 * @var bool
	 */
	protected bool $equals = true;

	/**
	 * Where constructor.
	 *
	 * @param  mixed $values
	 * @param  string|null $column
	 * @param  bool $equals
	 *
	 * @return void
	 */
	public function __construct(mixed $values, string|null $column = null, bool $equals = true) {
		$this->values = Arr::withoutEmpty(Arr::wrap($values));
		$this->column = $column ?: $this->column;
		$this->equals = $equals;
	}

	/**
	 * @return bool
	 */
	public function hasValues(): bool {
		return !empty($this->values);
	}

	/**
	 * @return $this
	 */
	public function equals(bool $enable = true): self {
		$this->equals = $enable;

		return $this;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		return $builder->when($this->hasValues(), function ($query) {
			return $this->howUseCondition($query);
		});
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return string
	 */
	protected function resolveColumn($builder): string {
		return $builder->queryColumn($this->column);
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	protected function howUseCondition($builder) {
		if(!$this->hasValues())
			return $builder;

		if(count($this->values) > 1) {
			if($this->equals)
				$builder->whereIn($this->resolveColumn($builder), $this->values);
			else
				$builder->whereNotIn($this->resolveColumn($builder), $this->values);
		} else {
			$id = Arr::first($this->values);

			if($this->values)
				$builder->where($this->resolveColumn($builder), $id);
			else
				$builder->where($this->resolveColumn($builder), '<>', $id);
		}

		return $builder;
	}
}
