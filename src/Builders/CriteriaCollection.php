<?php

namespace IhorOk\QueryCriteria\Builders;

use IhorOk\QueryCriteria\Helpers\HasCriteriaSelector;
use IhorOk\QueryCriteria\Helpers\HasDynamoDb;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaBuilder;
use IhorOk\QueryCriteria\Helpers\HasUnion;
use Illuminate\Support\Collection;

/**
 * Criteria builder with collection of this criteria. Use Laravel's Collection for store this criteria.
 *
 * @package App\Criteria
 */
class CriteriaCollection implements CriteriaBuilder {
	use HasUnion, HasDynamoDb, HasCriteriaSelector;

	/**
	 * Store for criteria.
	 *
	 * @var Collection $collection
	 */
	private Collection $collection;

	/**
	 * CriteriaCollection constructor.
	 *
	 * @param  Criteria[] $criteriaList
	 *
	 * @return void
	 */
	public function __construct(array $criteriaList) {
		$this->init($criteriaList);
	}

	/**
	 * @param  array $criteriaList
	 *
	 * @return static
	 */
	public static function create(array $criteriaList) {
		return new static($criteriaList);
	}

	/**
	 * @param  array $criteriaList
	 *
	 * @return CriteriaCollection
	 */
	public function init(array $criteriaList): self {
		$this->collection = new Collection($this->preFilterCriteriaList($criteriaList));
		$this->collection = $this->collection->keyBy(fn($criteria) => get_class($criteria));

		return $this;
	}

	/**
	 * Returns builder by applies criteria.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
	 */
	public function compose($builder) {
		$criteriaList = $this->preFilterCriteriaList($this->criteriaList());

		foreach ($criteriaList as $criteria)
			$this->applyCriteria($criteria, $builder);

		return $this->applyUnion($builder);
	}

	/**
	 * Returns builder by applied single criteria.
	 *
	 * @param  Criteria $criteria
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder
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
		$this->collection->offsetSet($key, $criteria);

		return $this;
	}

	/**
	 * @param  string $criteriaClassName
	 *
	 * @return static
	 */
	public function excludeCriteria(string $criteriaClassName): static {
		$this->collection->except($criteriaClassName);

		return $this;
	}

	/**
	 * @return array
	 */
	public function criteriaList(): array {
		return $this->preFilterCriteriaList($this->collection->all());
	}

	/**
	 * @return bool
	 */
	public function hasCriteriaList(): bool {
		return !empty($this->preFilterCriteriaList($this->collection->all()));
	}

	/**
	 * @param  array $criteriaList
	 *
	 * @return array
	 */
	public function preFilterCriteriaList(array $criteriaList): array {
		return array_filter($criteriaList, fn($criteria) => $criteria instanceof Criteria);
	}
}
