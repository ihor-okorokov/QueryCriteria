<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class FullTextCriteria implements Criteria {
	/**
	 * @var string
	 */
	protected string $column;

	/**
	 * @var string|null
	 */
	protected string|null $text;

	/**
	 * FullTextCriteria constructor.
	 *
	 * @param  string $column
	 * @param  string|null $text
	 *
	 * @return void
	 */
	public function __construct(string $column, string|null $text = null) {
		$this->column = $column;
		$this->text = $text;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		return $builder->where($builder->queryColumn($this->column), 'like', "%{$this->text}%");
	}
}
