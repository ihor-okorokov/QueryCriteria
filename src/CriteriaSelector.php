<?php

namespace IhorOk\QueryCriteria;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

interface CriteriaSelector {
	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return static
	 */
	public function setQueryBuilder($builder): static;

	/**
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|null
	 */
	public function getQueryBuilder();

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return Collection
	 */
	public function fetchAll(bool $onlyWithCriteriaSet = false): Collection;

	/**
	 * @param  int $total
	 * @param  int $page
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return Collection
	 */
	public function fetch(int $total, int $page = 1, bool $onlyWithCriteriaSet = false): Collection;

	/**
	 * @param  int $total
	 * @param  int $page
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return LengthAwarePaginatorContract
	 */
	public function paginate(int $total, int $page = 1, bool $onlyWithCriteriaSet = false): LengthAwarePaginatorContract;

	/**
	 * @param  bool $onlyWithCriteriaSet
	 * @param  bool $throwFailCase
	 *
	 * @return Model|null
	 */
	public function first(bool $onlyWithCriteriaSet = false, bool $throwFailCase = false): Model|null;

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return int
	 */
	public function count(bool $onlyWithCriteriaSet = false): int;

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return bool
	 */
	public function exists(bool $onlyWithCriteriaSet = false): bool;

	/**
	 * @param  callable $callback
	 * @param  int $total
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return void
	 */
	public function chunk(callable $callback, int $total = 1000, bool $onlyWithCriteriaSet = false): void;

	/**
	 * @param  callable $callback
	 * @param  int $total
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return void
	 */
	public function each(callable $callback, int $total = 1000, bool $onlyWithCriteriaSet = false): void;
}
