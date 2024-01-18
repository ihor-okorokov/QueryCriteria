<?php

namespace IhorOk\QueryCriteria\Criteria\DynamoDb;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class WithIndex implements Criteria {
	/**
	 * @var string
	 */
	protected string $index;

	/**
	 * @param  string $index
	 */
	public function __construct(string $index) {
		$this->index = $index;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes|DynamoDbQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes|DynamoDbQueryBuilder
	 */
	public function apply($builder) {
		return $builder->withIndex($this->index);
	}
}
