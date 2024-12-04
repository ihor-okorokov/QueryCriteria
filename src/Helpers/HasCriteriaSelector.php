<?php

namespace IhorOk\QueryCriteria\Helpers;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria\Limit;
use IhorOk\QueryCriteria\Criteria\Take;
use Illuminate\Contracts\Pagination\CursorPaginator as CursorPaginatorContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasCriteriaSelector {
	/**
	 * @var IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|null
	 */
	protected $queryBuilder = null;

	/**
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder $builder
	 *
	 * @return $this
	 */
	public function setQueryBuilder($builder): static {
		$this->queryBuilder = $builder;

		return $this;
	}

	/**
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|null
	 */
	public function getQueryBuilder() {
		return $this->queryBuilder;
	}

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return Collection
	 */
	public function fetchAll(bool $onlyWithCriteriaSet = false): Collection {
		return $this->fetch(total: -1, onlyWithCriteriaSet: $onlyWithCriteriaSet);
	}

	/**
	 * @param  int $total
	 * @param  int $page
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return Collection
	 */
	public function fetch(int $total, int $page = 1, bool $onlyWithCriteriaSet = false): Collection {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return new Collection();
		}

		return $this
			->includeCriteria(new Take($total, $page))
			->includeCriteria(new Limit($total))
			->compose($this->queryBuilder)
			->get();
	}

	/**
	 * @param  int $total
	 * @param  int $page
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return LengthAwarePaginatorContract
	 */
	public function paginate(int $total, int $page = 1, bool $onlyWithCriteriaSet = false): LengthAwarePaginatorContract {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return new LengthAwarePaginator(new Collection(), 0, $total);
		}

		return $this->compose($this->queryBuilder)->paginate(perPage: $total, page: $page);
	}

	/**
	 * @param  int $total
	 * @param  string|null $cursor
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return CursorPaginatorContract
	 */
	public function cursorPaginate(int $total, string|null $cursor = null, bool $onlyWithCriteriaSet = false): CursorPaginatorContract {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return new CursorPaginator(new Collection(), $total, $cursor);
		}

		return $this->compose($this->queryBuilder)->cursorPaginate(perPage: $total, cursor: $cursor);
	}

	/**
	 * @param  bool $onlyWithCriteriaSet
	 * @param  bool $throwFailCase
	 *
	 * @return Model|null
	 */
	public function first(bool $onlyWithCriteriaSet = false, bool $throwFailCase = false): Model|null {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return null;
		}

		$query = $this->compose($this->queryBuilder);

		return $throwFailCase ? $query->firstOrFail() : $query->first();
	}

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return int
	 */
	public function count(bool $onlyWithCriteriaSet = false): int {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return 0;
		}

		return $this->compose($this->queryBuilder)->count();
	}

	/**
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return bool
	 */
	public function exists(bool $onlyWithCriteriaSet = false): bool {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return false;
		}

		return $this->compose($this->queryBuilder)->exists();
	}

	/**
	 * @param  callable $callback
	 * @param  int $total
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return void
	 */
	public function chunk(callable $callback, int $total = 1000, bool $onlyWithCriteriaSet = false): void {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return;
		}

		$this->compose($this->queryBuilder)->chunk($total, $callback);
	}

	/**
	 * @param  callable $callback
	 * @param  int $total
	 * @param  bool $onlyWithCriteriaSet
	 *
	 * @return void
	 */
	public function each(callable $callback, int $total = 1000, bool $onlyWithCriteriaSet = false): void {
		if(!$this->queryBuilder || ($onlyWithCriteriaSet && !$this->hasCriteriaList())) {
			return;
		}

		$this->compose($this->queryBuilder)->each($callback, $total);
	}
}
