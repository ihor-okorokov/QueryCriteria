<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\Helpers\HasJoins;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

/**
 * Criteria using an anonymous function to quickly describe the conditions of the builder query without creating a separate criterion.
 *
 * @package IhorOk\QueryCriteria\Criteria
 */
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
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function apply($builder) {
		$constraints = $this->callback;

		return $constraints($builder);
	}
}
