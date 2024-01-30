<?php

namespace IhorOk\QueryCriteria;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
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
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes
	 */
	public function apply($builder);
}
