<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

/**
 * Base criteria for sort items.
 *
 * @package IhorOk\QueryCriteria\Criteria
 */
class Sort implements Criteria {
	/**
	 * @var string|null
	 */
	protected string|null $column = 'created_at';

	/**
	 * @var string|null
	 */
	protected string|null $direction = 'asc';

	/**
	 * Sort constructor.
	 *
	 * @param  string|null $column
	 * @param  string|null $direction
	 *
	 * @return void
	 */
	public function __construct(string|null $column = 'created_at', string|null $direction = 'asc') {
		$this->column = $column ?: 'created_at';
		$this->direction = $direction ?: 'asc';
	}

	/**
	 * Adds 'ORDER BY' to query builder.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		return $builder->when(
			!empty($this->column),

			/* @var IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $query */
			fn($query) => $query->orderBy($query->queryColumn($this->column), $this->direction)
		);
	}
}
