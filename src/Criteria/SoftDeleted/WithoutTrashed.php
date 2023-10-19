<?php

namespace IhorOk\QueryCriteria\Criteria\SoftDeleted;

use IhorOk\QueryCriteria\Criteria;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithoutTrashed implements Criteria {
	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|SoftDeletes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|SoftDeletes
	 */
	public function apply($builder) {
		return $builder->withoutTrashed();
	}
}
