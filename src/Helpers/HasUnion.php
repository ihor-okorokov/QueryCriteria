<?php

namespace IhorOk\QueryCriteria\Helpers;

use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use IhorOk\QueryCriteria\CriteriaBuilder;
use Illuminate\Support\Arr;

trait HasUnion {
	/**
	 * @var array
	 */
	protected array $unions = [];

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	protected function applyUnion($builder) {
		foreach($this->unions as $union) {
			$criteriaBuilder = Arr::get($union, 'builder');
			$all = Arr::get($union, 'all');

			/* @var CriteriaBuilder $criteriaBuilder */
			$builder->union($criteriaBuilder->compose($builder->newModelInstance()->newQueryWithoutRelationships()), $all);
		}

		return $builder;
	}

	/**
	 * @return bool
	 */
	public function hasUnion(): bool {
		return !empty($this->unions);
	}

	/**
	 * @param  CriteriaBuilder $criteriaBuilder
	 * @param  bool $all
	 *
	 * @return static
	 */
	public function union(CriteriaBuilder $criteriaBuilder, bool $all = true): static {
		$this->unions[] = ['builder' => $criteriaBuilder, 'all' => $all];

		return $this;
	}
}
