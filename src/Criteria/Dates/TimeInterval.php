<?php

namespace IhorOk\QueryCriteria\Criteria\Dates;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class TimeInterval implements Criteria {
	const SECOND_FRAME = 'SECOND';
	const MINUTE_FRAME = 'MINUTE';
	const HOUR_FRAME = 'HOUR';
	const DAY_FRAME = 'DAY';
	const MONTH_FRAME = 'MONTH';
	const YEAR_FRAME = 'YEAR';

	/**
	 * @var int
	 */
	protected int $interval;

	/**
	 * @var string
	 */
	protected string $timeFrame;

	/**
	 * @var string
	 */
	protected string $column;

	/**
	 * @var string
	 */
	protected string $operator;

	/**
	 * @param  int $interval
	 * @param  string $timeFrame
	 * @param  string $column
	 * @param  string $operator
	 */
	public function __construct(int $interval, string $timeFrame, string $column = 'created_at', string $operator = '<=') {
		$this->interval = $interval;
		$this->timeFrame = $timeFrame;
		$this->column = $column;
		$this->operator = $operator;
	}

	/**
	 * @param  DynamoDbQueryBuilder|CriteriaScopes|IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return DynamoDbQueryBuilder|CriteriaScopes|IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function apply($builder) {
		$column = $builder->queryColumn($this->column);

		return $builder->whereRaw("if({$column} is not null, {$column} {$this->operator} now() - INTERVAL {$this->interval} {$this->timeFrame}, 0)");
	}
}
