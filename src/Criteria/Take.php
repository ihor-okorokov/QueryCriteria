<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class Take implements Criteria {
	/**
	 * @var int
	 */
	protected int $total;

	/**
	 * @var int
	 */
	protected int $page;

	/**
	 * Take constructor.
	 *
	 * @param  int $total
	 * @param  int $page
	 */
	public function __construct(int $total, int $page) {
		$this->total = $total;
		$this->page = $page;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		$offset = $this->page >= 1 ? (($this->page - 1) * $this->total) : 0;

		if($offset <= 0)
			return $builder;

		return $builder->offset($offset);
	}
}
