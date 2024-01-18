<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use IhorOk\QueryCriteria\Helpers\HasJoins;
use IhorOk\QueryCriteria\Support\Arr;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class OrCriteria implements Criteria {
	use HasJoins;

	/**
	 * @var Criteria[]
	 */
	protected array $criteriaList;

	/**
	 * OrCriteria constructor.
	 *
	 * @param  Criteria[] $criteriaList
	 */
	public function __construct(Criteria...$criteriaList) {
		$this->criteriaList = Arr::wrap($criteriaList);
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		$this->applyJoins($builder);

		foreach ($this->criteriaList as $criteria) {
			if (method_exists($criteria, 'applyJoins')) {
				$criteria->applyJoins($builder);
			}
		}

		return $builder->where(function ($builder) {
			/* @var IlluminateEloquentBuilder|IlluminateQueryBuilder $builder */
			foreach ($this->criteriaList as $criteria) {
				$builder->orWhere(fn($query) => $criteria->apply($query));
			}
		});
	}
}
