<?php

namespace IhorOk\QueryCriteria\Criteria\DynamoDb;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class GroupCriteriaList implements Criteria {
	/**
	 * @var GroupCriteria[]
	 */
	protected array $groupCriteria;

	/**
	 * @param  GroupCriteria[] $groupCriteria
	 */
	public function __construct(array $groupCriteria) {
		$this->groupCriteria = $groupCriteria;
	}

	/**
	 * @return GroupCriteria[]
	 */
	public function getGroupCriteria(): array {
		return $this->groupCriteria;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder
	 */
	public function apply($builder) {
		if(property_exists($builder, 'groupCriteriaList'))
			$builder->groupCriteriaList = $this;

		return $builder;
	}
}
