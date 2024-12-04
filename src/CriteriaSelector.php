<?php

namespace IhorOk\QueryCriteria;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use Illuminate\Contracts\Pagination\CursorPaginator as CursorPaginatorContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

interface CriteriaSelector {
	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder $builder
	 *
	 * @return static
	 */
	public function setQueryBuilder($builder): static;

	/**
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|null
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
	 * @param  int $total
	 * @param  string|null $cursor
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return CursorPaginatorContract
	 */
	public function cursorPaginate(int $total, string|null $cursor = null, bool $onlyWithCriteriaSet = false): CursorPaginatorContract;

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
