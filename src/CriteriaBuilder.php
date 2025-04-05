<?php

namespace IhorOk\QueryCriteria;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

/**
 * Interface for building a query based on a list of criteria.
 *
 * @package IhorOk\QueryCriteria
 */
interface CriteriaBuilder extends CriteriaSelector {
	/**
	 * @param  CriteriaBuilder $criteriaBuilder
	 * @param  bool $all
	 *
	 * @return self
	 */
	public function union(self $criteriaBuilder, bool $all = true): self;

	/**
	 * Returns builder by applies criteria.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes
	 */
	public function compose($builder);

	/**
	 * Returns builder by applied single criteria.
	 *
	 * @param  Criteria $criteria
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes
	 */
	public function applyCriteria(Criteria $criteria, $builder);

	/**
	 * Push criteria to the criteria list.
	 *
	 * @param  Criteria $criteria
	 * @param  string|null $key
	 *
	 * @return self
	 */
	public function includeCriteria(Criteria $criteria, ?string $key = null): self;

	/**
	 * Exclude criteria from the list.
	 *
	 * @param  string $criteriaClassName class name of class implements Criteria
	 *
	 * @return self
	 */
	public function excludeCriteria(string $criteriaClassName): self;

	/**
	 * Returns a list of possible search criteria.
	 *
	 * @return Criteria[]
	 */
	public function criteriaList(): array;

	/**
	 * @return array
	 */
	public function dynamoDbCriteriaList(): array;

	/**
	 * @param  bool $enable
	 *
	 * @return self
	 */
	public function useDynamoDb(bool $enable = true): self;

	/**
	 * @return bool
	 */
	public function isUseDynamoDb(): bool;

	/**
	 * Check has list criteria.
	 *
	 * @return bool
	 */
	public function hasCriteriaList(): bool;

	/**
	 * Pre-filter criteria list before apply to builder.
	 *
	 * @param  array $criteriaList
	 *
	 * @return array
	 */
	public function preFilterCriteriaList(array $criteriaList): array;
}
