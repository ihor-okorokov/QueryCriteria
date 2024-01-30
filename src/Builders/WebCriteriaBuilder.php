<?php

namespace IhorOk\QueryCriteria\Builders;

use BaoPham\DynamoDb\DynamoDbQueryBuilder;
use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use IhorOk\QueryCriteria\Helpers\HasCriteriaSelector;
use IhorOk\QueryCriteria\Helpers\HasDynamoDb;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;
use IhorOk\QueryCriteria\CriteriaBuilder;
use IhorOk\QueryCriteria\Helpers\HasUnion;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Criteria builder for building a query based on a list of criteria filtered based on the query.
 *
 * @package IhorOk\QueryCriteria\Builders
 */
abstract class WebCriteriaBuilder implements CriteriaBuilder {
	use HasUnion, HasDynamoDb, HasCriteriaSelector;

	/**
	 * @var Request|null
	 */
	protected ?Request $request;

	/**
	 * List of criteria to be included to the list.
	 *
	 * @var string[]
	 */
	protected array $includedCriteria = [];

	/**
	 * List of criteria to be excluded from the list.
	 *
	 * @var string[]
	 */
	protected array $exceptCriteria = [];

	/**
	 * BaseCriteriaBuilder constructor.
	 *
	 * @param  Request|null $request
	 *
	 * @return void
	 */
	public function __construct(?Request $request = null) {
		$this->request = $request ?: \request();

		$this->init();
	}

	/**
	 * Getter for Request object.
	 *
	 * @return Request
	 */
	public function getRequest(): Request {
		return $this->request;
	}

	/**
	 * Initialize this object. Called in construct.
	 */
	public function init() {
		// ...
	}

	/**
	 * @return static
	 */
	public function clone() {
		return clone $this;
	}

	/**
	 * Returns builder by applies criteria.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes
	 */
	public function compose($builder) {
		$criteriaList = $this->preFilterCriteriaList($this->resolveCriteriaList());

		foreach ($criteriaList as $filterParameter => $criteria)
			$this->applyCriteria($criteria, $builder);

		return $this->applyUnion($builder);
	}

	/**
	 * Returns builder by applied single criteria.
	 *
	 * @param  Criteria $criteria
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|DynamoDbQueryBuilder|CriteriaScopes
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
		if (is_null($key))
			$this->includedCriteria[] = $criteria;
		else
			$this->includedCriteria[$key] = $criteria;

		return $this;
	}

	/**
	 * To store criteria that need to be dynamically excluded from the list.
	 *
	 * @param  string $criteriaClassName
	 *
	 * @return static
	 */
	public function excludeCriteria(string $criteriaClassName): static {
		$this->exceptCriteria[] = $criteriaClassName;

		return $this;
	}

	/**
	 * Check if list of criteria is not empty.
	 *
	 * @return bool
	 */
	public function hasCriteriaList(): bool {
		return !empty($this->preFilterCriteriaList($this->resolveCriteriaList()));
	}

	/**
	 * Returns an associative array with a list of criteria that is prefiltered by the parameters,
	 * being as the keys of the elements of the array with the parameters, being in the request.
	 *
	 * @param  array $criteriaList
	 *
	 * @return Criteria[]
	 *
	 * @see criteriaList()
	 */
	public function preFilterCriteriaList(array $criteriaList): array {
		// exclude empty criteria
		$criteriaList = array_filter($criteriaList, fn($item) => !empty($item));

		// exclude no need criteria from list by classes names
		$criteriaList = array_filter($criteriaList, fn($criteria) => !in_array(get_class($criteria), $this->exceptCriteria));

		// include criteria to list
		$criteriaList = array_merge($criteriaList, $this->includedCriteria);

		$defaultCriteriaList = array_filter($criteriaList, fn($key) => is_numeric($key), ARRAY_FILTER_USE_KEY);

		$namedCriteriaList = array_filter($criteriaList, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);

		$usedCriteriaListByRequest = Arr::only($criteriaList, array_keys($this->request->only(array_keys($namedCriteriaList))));

		return array_merge($defaultCriteriaList, $usedCriteriaListByRequest);
	}

	/**
	 * Merge two arrays with list criteria.
	 * Need if criteria extends other criteria.
	 *
	 * @param  Criteria[] $parents
	 * @param  Criteria[] $children
	 *
	 * @return array
	 *
	 * @see criteriaList()
	 */
	protected function mergeCriteria(array $parents, array $children): array {
		foreach ($children as $key => $criteria) {
			if (is_numeric($key)) {
				array_push($parents, $criteria);
			} else {
				$parents[$key] = $criteria;
			}
		}

		return $parents;
	}
}
