<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class Sort implements Criteria {
	/**
	 * @var string|null
	 */
	protected ?string $column = 'created_at';

	/**
	 * @var string|null
	 */
	protected ?string $direction = 'asc';

	/**
	 * Sort constructor.
	 *
	 * @param  string|null $column
	 * @param  string|null $direction
	 *
	 * @return void
	 */
	public function __construct(?string $column = 'created_at', ?string $direction = 'asc') {
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
