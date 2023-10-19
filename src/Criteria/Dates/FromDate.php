<?php

namespace IhorOk\QueryCriteria\Criteria\Dates;

use IhorOk\QueryCriteria\Criteria\GreaterThan;

class FromDate extends GreaterThan {
	/**
	 * @var string
	 */
	protected string $column = 'created_at';
}
