<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class Limit implements Criteria {
	/**
	 * @var int
	 */
	protected int $limit;

	/**
	 * Limit constructor.
	 *
	 * @param  int $limit
	 */
	public function __construct(int $limit) {
		$this->limit = $limit;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function apply($builder) {
		return $builder->limit(
			$this->limit > 0 && $this->limit <= 1000
				? $this->limit
				: ($this->limit < 0 ? 1000 : 50)
		);
	}
}
