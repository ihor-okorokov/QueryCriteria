<?php

namespace IhorOk\QueryCriteria;

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
	 * @return static
	 */
	public function union(self $criteriaBuilder, bool $all = true): static;

	/**
	 * Returns builder by applies criteria.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function compose($builder);

	/**
	 * Returns builder by applied single criteria.
	 *
	 * @param  Criteria $criteria
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function applyCriteria(Criteria $criteria, $builder);

	/**
	 * Push criteria to the criteria list.
	 *
	 * @param  Criteria $criteria
	 * @param  string|null $key
	 *
	 * @return static
	 */
	public function includeCriteria(Criteria $criteria, ?string $key = null): static;

	/**
	 * Exclude criteria from the list.
	 *
	 * @param  string $criteriaClassName class name of class implements Criteria
	 *
	 * @return static
	 */
	public function excludeCriteria(string $criteriaClassName): static;

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
	 * @return static
	 */
	public function useDynamoDb(bool $enable = true): static;

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
