<?php

namespace IhorOk\QueryCriteria\Criteria\DynamoDb;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
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
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder
	 */
	public function apply($builder) {
		/* @var Criteria $criteria] */
		foreach($this->criteriaList as $criteria)
			$builder = $criteria->apply($builder);

		return $builder;
	}
}
