<?php

namespace IhorOk\QueryCriteria\Criteria\Dates;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Support\Carbon;

class WhereDate implements Criteria {
	/**
	 * @var Carbon|string
	 */
	protected Carbon|string $date;

	/**
	 * @var string
	 */
	protected string $column = 'created_at';

	/**
	 * @param  Carbon|string $date
	 * @param  string $column
	 */
	public function __construct(Carbon|string $date, string $column = 'created_at') {
		$this->date = $date;
		$this->column = $column;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		$date = $this->date instanceof Carbon ? $this->date->format('Y-m-d') : $this->date;

		return $builder->whereDate($builder->queryColumn($this->column), $date);
	}
}
