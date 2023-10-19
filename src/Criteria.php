<?php

namespace IhorOk\QueryCriteria;

use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

/**
 * Interface to describe the rules to the query builder.
 *
 * @package IhorOk\QueryCriteria
 */
interface Criteria {
	/**
	 * Apply criteria conditions to query builder.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function apply($builder);
}
