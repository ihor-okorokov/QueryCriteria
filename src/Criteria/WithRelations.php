<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class WithRelations implements Criteria {
	/**
	 * @var array
	 */
	public array $relations = [];

	/**
	 * WithRelations constructor.
	 *
	 * @param  array $relations
	 */
	public function __construct(array $relations = []) {
		$this->relations = $relations;
	}

	/**
	 * @param  array $relations
	 *
	 * @return array
	 */
	public static function relations(array $relations = []): array {
		return array_merge([], $relations);
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function apply($builder) {
		return $builder->with(array_merge(static::relations(), $this->relations));
	}
}
