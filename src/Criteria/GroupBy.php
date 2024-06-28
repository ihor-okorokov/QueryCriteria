<?php

namespace IhorOk\QueryCriteria\Criteria;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class GroupBy implements Criteria {
	/**
	 * @param  array $groups
	 */
	public function __construct(protected array $groups) { }

	/**
	 * @param  DynamoDbQueryBuilder|CriteriaScopes|IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return DynamoDbQueryBuilder|CriteriaScopes|IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function apply($builder) {
		return $builder->groupBy($this->groups);
	}
}
