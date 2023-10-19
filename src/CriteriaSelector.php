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
	 * @return $this
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
	public function fetchAllWithCriteria(bool $onlyWithCriteriaSet = false): Collection;

	/**
	 * @param  int $total
	 * @param  int $page
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return Collection
	 */
	public function fetchWithCriteria(int $total, int $page = 1, bool $onlyWithCriteriaSet = false): Collection;

	/**
	 * @param  int $total
	 * @param  int $page
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return LengthAwarePaginatorContract
	 */
	public function paginateWithCriteria(int $total, int $page = 1, bool $onlyWithCriteriaSet = false): LengthAwarePaginatorContract;

	/**
	 * @param  bool $onlyWithCriteriaSet
	 * @param  bool $throwFailCase
	 *
	 * @return Model|null
	 */
	public function firstWithCriteria(bool $onlyWithCriteriaSet = false, bool $throwFailCase = false): Model|null;

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return int
	 */
	public function countWithCriteria(bool $onlyWithCriteriaSet = false): int;

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return bool
	 */
	public function existsWithCriteria(bool $onlyWithCriteriaSet = false): bool;

	/**
	 * @param  callable $callback
	 * @param  int $total
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return void
	 */
	public function chunkWithCriteria(callable $callback, int $total = 1000, bool $onlyWithCriteriaSet = false): void;

	/**
	 * @param  callable $callback
	 * @param  int $total
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return void
	 */
	public function eachWithCriteria(callable $callback, int $total = 1000, bool $onlyWithCriteriaSet = false): void;
}
