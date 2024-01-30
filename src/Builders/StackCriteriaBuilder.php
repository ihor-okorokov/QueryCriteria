<?php

namespace IhorOk\QueryCriteria\Builders;

use IhorOk\QueryCriteria\CriteriaScopes;
use IhorOk\QueryCriteria\Helpers\HasCriteriaSelector;
use IhorOk\QueryCriteria\Helpers\HasDynamoDb;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaBuilder;
use IhorOk\QueryCriteria\Helpers\HasUnion;
use Illuminate\Support\Collection;

/**
 * Criteria Builder with collection of these criteria. Using Laravel's Collection for store these criteria.
 *
 * @package IhorOk\QueryCriteria\Builders
 */
class StackCriteriaBuilder implements CriteriaBuilder {
	use HasUnion, HasDynamoDb, HasCriteriaSelector;

	/**
	 * General criteria list.
	 *
	 * @var Collection
	 */
	protected Collection $generalCriteriaList;

	/**
	 * Criteria list for DynamoDb strategy.
	 *
	 * @var Collection
	 */
	protected Collection $dynamoDbCriteriaList;

	/**
	 * StackCriteriaBuilder constructor.
	 *
	 * @param  Criteria[] $generalCriteriaList
	 * @param  Criteria[] $dynamoDbCriteriaList
	 *
	 * @return void
	 */
	public function __construct(array $generalCriteriaList, array $dynamoDbCriteriaList = []) {
		$this->generalCriteriaList = $this->init($generalCriteriaList);
		$this->dynamoDbCriteriaList = $this->init($dynamoDbCriteriaList);
	}

	/**
	 * @param  Criteria[] $generalCriteriaList
	 * @param  Criteria[] $dynamoDbCriteriaList
	 *
	 * @return static
	 */
	public static function create(array $generalCriteriaList, array $dynamoDbCriteriaList = []) {
		return new static($generalCriteriaList, $dynamoDbCriteriaList);
	}

	/**
	 * @param  array $criteriaList
	 *
	 * @return Collection
	 */
	public function init(array $criteriaList): Collection {
		$collection = new Collection($this->preFilterCriteriaList($criteriaList));

		return $collection->keyBy(fn($criteria) => get_class($criteria));
	}

	/**
	 * Returns builder by applies criteria.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function compose($builder) {
		$criteriaList = $this->preFilterCriteriaList($this->resolveCriteriaList());

		foreach ($criteriaList as $criteria)
			$this->applyCriteria($criteria, $builder);

		return $this->applyUnion($builder);
	}

	/**
	 * Returns builder by applied single criteria.
	 *
	 * @param  Criteria $criteria
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function applyCriteria(Criteria $criteria, $builder) {
		return $criteria->apply($builder);
	}

	/**
	 * @param  Criteria $criteria
	 * @param  string|null $key
	 *
	 * @return static
	 */
	public function includeCriteria(Criteria $criteria, ?string $key = null): static {
		$this->resolveCriteriaCollection()->offsetSet($key, $criteria);

		return $this;
	}

	/**
	 * @param  string $criteriaClassName
	 *
	 * @return static
	 */
	public function excludeCriteria(string $criteriaClassName): static {
		$this->resolveCriteriaCollection()->except($criteriaClassName);

		return $this;
	}

	/**
	 * @return array
	 */
	public function criteriaList(): array {
		return $this->generalCriteriaList->all();
	}

	/**
	 * @return array
	 */
	public function dynamoDbCriteriaList(): array {
		return $this->dynamoDbCriteriaList->all();
	}

	/**
	 * @return bool
	 */
	public function hasCriteriaList(): bool {
		return !empty($this->preFilterCriteriaList($this->resolveCriteriaCollection()->all()));
	}

	/**
	 * @param  array $criteriaList
	 *
	 * @return array
	 */
	public function preFilterCriteriaList(array $criteriaList): array {
		return array_filter($criteriaList, fn($criteria) => $criteria instanceof Criteria);
	}

	/**
	 * @return Collection
	 */
	protected function resolveCriteriaCollection(): Collection {
		return $this->useDynamoDb ? $this->dynamoDbCriteriaList : $this->generalCriteriaList;
	}
}
