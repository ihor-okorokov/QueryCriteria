<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use IhorOk\QueryCriteria\Helpers\HasJoins;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class QuickCriteria implements Criteria {
	use HasJoins;

	/**
	 * @var \Closure
	 */
	protected \Closure $callback;

	/**
	 * QuickCriteria constructor.
	 *
	 * @param  \Closure $callback
	 *
	 * @return void
	 */
	public function __construct(\Closure $callback) {
		$this->callback = $callback;
	}

	/**
	 * Call callback function and apply criteria to query builder.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		$constraints = $this->callback;

		return $constraints($builder);
	}
}
