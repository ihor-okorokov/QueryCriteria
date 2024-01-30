<?php

namespace IhorOk\QueryCriteria;

use IhorOk\QueryCriteria\Builders\StackCriteriaBuilder;
use IhorOk\QueryCriteria\CriteriaBuilder as CriteriaBuilderContract;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder|static queryCriteriaBuilder(CriteriaBuilderContract $criteriaBuilder)
 * @method static Builder|static queryCriteriaBuilder(CriteriaBuilderContract $criteriaBuilder)
 *
 * @method Builder|static queryCriteria(Criteria... $list)
 * @method static Builder|static queryCriteria(Criteria... $list)
 *
 * @method CriteriaSelector criteriaBuilder(CriteriaBuilderContract $criteriaBuilder)
 * @method static CriteriaSelector criteriaBuilder(CriteriaBuilderContract $criteriaBuilder)
 *
 * @method CriteriaSelector criteria(Criteria... $list)
 * @method static CriteriaSelector criteria(Criteria... $list)
 *
 * @method CriteriaSelector dynamoDbCriteria(Criteria... $list)
 * @method static CriteriaSelector dynamoDbCriteria(Criteria... $list)
 *
 * @method Builder|static queryRootAlias(string $alias)
 * @method static Builder|static queryRootAlias(string $alias)
 *
 * @method Builder|static queryColumn(string $column)
 * @method static Builder|static queryColumn(string $column)
 */
trait CriteriaScopes {
	/**
	 * Alias for FROM case in SQL query.
	 *
	 * @var string|null
	 */
	protected string|null $queryRootAlias = null;

	/**
	 * @param  Builder $query
	 * @param  CriteriaBuilder $criteriaBuilder
	 *
	 * @return Builder
	 */
	public function scopeQueryCriteriaBuilder($query, CriteriaBuilderContract $criteriaBuilder) {
		return $criteriaBuilder->compose($query);
	}

	/**
	 * @param  Builder $query
	 * @param  Criteria ...$list
	 *
	 * @return Builder
	 */
	public function scopeQueryCriteria($query, Criteria... $list) {
		foreach ($list as $criteria)
			$criteria->apply($query);

		return $query;
	}

	/**
	 * @param  Builder $query
	 * @param  CriteriaBuilder $criteriaBuilder
	 *
	 * @return CriteriaSelector
	 */
	public function scopeCriteriaBuilder($query, CriteriaBuilderContract $criteriaBuilder): CriteriaSelector {
		return $criteriaBuilder->setQueryBuilder($query);
	}

	/**
	 * @param  Builder $query
	 * @param  Criteria ...$list
	 *
	 * @return CriteriaSelector
	 */
	public function scopeCriteria($query, Criteria... $list): CriteriaSelector {
		return StackCriteriaBuilder::create($list)->setQueryBuilder($query);
	}

	/**
	 * @param  Builder $query
	 * @param  Criteria ...$list
	 *
	 * @return CriteriaSelector
	 */
	public function scopeDynamoDbCriteria($query, Criteria... $list): CriteriaSelector {
		return StackCriteriaBuilder::create([], $list)->useDynamoDb()->setQueryBuilder($query);
	}

	/**
	 * @param  Builder $query
	 * @param  string $alias
	 *
	 * @return Builder
	 */
	public function scopeQueryRootAlias(Builder $query, string $alias) {
		$this->queryRootAlias = $alias;
		$table = $query->getModel()->getTable();

		return $query->from("{$table} as {$alias}");
	}

	/**
	 * @param  Builder $query
	 * @param  string $column
	 *
	 * @return string
	 */
	public function scopeQueryColumn(Builder $query, string $column) {
		return $this->queryRootAlias
			? "{$this->queryRootAlias}.{$column}"
			: "{$this->getTable()}.{$column}";
	}
}
