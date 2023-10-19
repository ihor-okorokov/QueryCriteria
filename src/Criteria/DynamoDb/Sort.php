<?php

namespace IhorOk\QueryCriteria\Criteria\DynamoDb;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use BaoPham\DynamoDb\RawDynamoDbQuery;
use IhorOk\QueryCriteria\Criteria;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class Sort implements Criteria {
	/**
	 * @var string
	 */
	protected string $strategy;

	/**
	 * @param  string $strategy
	 */
	public function __construct(string $strategy = 'asc') {
		$this->strategy = $strategy;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder
	 */
	public function apply($builder) {
		return $builder->decorate(function (RawDynamoDbQuery $raw) {
			// desc order
			$raw->query['ScanIndexForward'] = $this->strategy == 'asc';
		});
	}
}
