<?php

namespace IhorOk\QueryCriteria\Criteria\DynamoDb;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class GroupCriteria implements Criteria {
	/**
	 * @var array
	 */
	protected array $criteriaList;

	/**
	 * @param  array $criteriaList
	 */
	public function __construct(array $criteriaList) {
		$this->criteriaList = array_filter($criteriaList, function($criteria) {
			return $criteria instanceof Criteria;
		});
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes|DynamoDbQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes|DynamoDbQueryBuilder
	 */
	public function apply($builder) {
		/* @var Criteria $criteria] */
		foreach($this->criteriaList as $criteria)
			$builder = $criteria->apply($builder);

		return $builder;
	}
}
