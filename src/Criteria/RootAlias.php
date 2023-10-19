<?php

namespace IhorOk\QueryCriteria\Criteria;

use IhorOk\QueryCriteria\Criteria;
use IhorOk\QueryCriteria\CriteriaScopes;
use Illuminate\Database\Eloquent\Builder as IlluminateEloquentBuilder;
use Illuminate\Database\Query\Builder as IlluminateQueryBuilder;

/**
 * Criteria for adds alias in expression SQL query 'FROM `table` as alias'.
 *
 * @package IhorOk\QueryCriteria\Criteria
 */
class RootAlias implements Criteria {
	/**
	 * @var string
	 */
	protected string $alias;

	/**
	 * RootAlias constructor.
	 *
	 * @param  string $alias
	 *
	 * @return void
	 */
	public function __construct(string $alias) {
		$this->alias = $alias;
	}

	/**
	 * Adds alias in expression SQL query 'FROM `table` as alias'.
	 * Use scoped function 'alias' in trait DefaultScoped.
	 *
	 * @param  IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes $builder
	 *
	 * @return IlluminateEloquentBuilder|IlluminateQueryBuilder|CriteriaScopes
	 */
	public function apply($builder) {
		return $builder->queryRootAlias($this->alias);
	}
}
