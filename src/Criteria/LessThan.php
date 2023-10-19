<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class LessThan implements Criteria {
	/**
	 * @var mixed
	 */
	protected mixed $value;

	/**
	 * @var string
	 */
	protected string $column = 'id';

	/**
	 * @var bool
	 */
	protected bool $andEqual = false;

	/**
	 * @param  mixed $value
	 * @param  string|null $column
	 * @param  bool $andEqual
	 */
	public function __construct(mixed $value, string|null $column = null, bool $andEqual = false) {
		$this->value = $value;
		$this->column = $column;
		$this->andEqual = $andEqual;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		return $builder->where($builder->queryColumn($this->column), ($this->andEqual ? '<=' : '<'), $this->value);
	}
}
