<?php

namespace IhorOk\QueryCriteria\Criteria\SoftDeleted;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithoutTrashed implements Criteria {
	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes|SoftDeletes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes|SoftDeletes
	 */
	public function apply($builder) {
		return $builder->withoutTrashed();
	}
}
