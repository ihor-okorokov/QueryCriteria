<?php

namespace IhorOk\QueryCriteria\Helpers;

use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Support\Arr;

/**
 * Trait for set or exclude JOIN clause to query builder.
 *
 * @package IhorOk\QueryCriteria\Helpers
 */
trait HasJoins {
	/**
	 * Tables names for exclude from join in query builder.
	 *
	 * @var array
	 */
	protected array $excludedJoins = [];

	/**
	 * Tables names for join to query builder.
	 *
	 * @var array
	 */
	protected array $includedJoins = [];

	/**
	 * Array with keys of tables names and their callbacks where apply join to query builder.
	 *
	 * @return array
	 */
	public function joins(): array {
		return [];
	}

	/**
	 * Set keys of table names for sql joins which need be removed from query builder.
	 *
	 * @param  array $tbNames
	 *
	 * @return self
	 */
	public function excludeJoins(array $tbNames = []) {
		$this->excludedJoins = array_merge($this->excludedJoins, $tbNames);

		return $this;
	}

	/**
	 * Returns excepted tables names.
	 *
	 * @return array
	 */
	public function getExcludedJoins() {
		return $this->excludedJoins;
	}

	/**
	 * Dynamic include joins.
	 *
	 * @param  array $joins
	 *
	 * @return $this
	 */
	public function includeJoins(array $joins) {
		$this->includedJoins = array_merge($this->includedJoins, $joins);

		return $this;
	}

	/**
	 * Returns included tables names.
	 *
	 * @return array
	 */
	public function getIncludedJoins() {
		return $this->includedJoins;
	}

	/**
	 * @return array
	 */
	public function resultJoins(): array {
		return array_merge(Arr::except($this->joins(), $this->excludedJoins), $this->includedJoins);
	}

	/**
	 * Apply sql joins to query builder from array joins which may be disabled in the future.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 * @param  array $onlyJoins
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function applyJoins($builder, array $onlyJoins = []) {
		/* @var \Closure[]|array $joins */
		$joins = array_merge(Arr::except($this->joins(), $this->excludedJoins), $this->includedJoins);

		$joins = Arr::only($joins, array_keys(($onlyJoins ?: $joins)));

		foreach ($joins as $tbName => $join)
			$join($builder);

		return $builder;
	}
}
