<?php

namespace IhorOk\QueryCriteria\Helpers;

trait HasDynamoDb {
	/**
	 * @var bool
	 */
	protected $useDynamoDb = false;

	/**
	 * @var bool
	 */
	protected $useDynamodbPartially = false;

	/**
	 * @return array
	 */
	public function dynamoDbCriteriaList(): array {
		return [];
	}

	/**
	 * @param  bool $enable
	 *
	 * @return self
	 */
	public function useDynamoDb(bool $enable = true): self {
		$this->useDynamoDb = $enable;

		return $this;
	}

	/**
	 * @param  bool $enable
	 *
	 * @return self
	 */
	public function useDynamodbPartially(bool $enable = true): self {
		$this->useDynamodbPartially = $enable;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isUseDynamoDb(): bool {
		return $this->useDynamoDb;
	}

	/**
	 * @return bool
	 */
	public function isUseDynamodbPartially(): bool {
		return $this->useDynamodbPartially;
	}

	/**
	 * @return array
	 */
	protected function resolveCriteriaList(): array {
		return $this->useDynamoDb ? $this->dynamoDbCriteriaList() : $this->criteriaList();
	}
}
