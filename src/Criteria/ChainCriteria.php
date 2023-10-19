<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\Helpers\HasJoins;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

class ChainCriteria implements Criteria {
	use HasJoins;

	/**
	 * @var Criteria ...$criteria
	 */
	protected array $list;

	/**
	 * @var bool
	 */
	protected bool $isNestedWhere = true;

	/**
	 * Chain constructor.
	 *
	 * @param  Criteria ...$criteria
	 */
	public function __construct(Criteria ...$criteria) {
		$this->list = $criteria;
	}

	/**
	 * @param  bool $enable
	 *
	 * @return $this
	 */
	public function nestedWhere(bool $enable = true): self {
		$this->isNestedWhere = $enable;

		return $this;
	}

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function apply($builder) {
		$this->applyJoins($builder);

		foreach ($this->list as $criteria) {
			if (method_exists($criteria, 'applyJoins'))
				$criteria->applyJoins($builder);
		}

		$callback = function ($builder) {
			/* @var IlluminateEloquentBuilder|IlluminateQueryBuilder $builder */
			foreach ($this->list as $criteria)
				$criteria->apply($builder);

			return $builder;
		};

		return $this->isNestedWhere ? $builder->where($callback) : $callback($builder);
	}
}
