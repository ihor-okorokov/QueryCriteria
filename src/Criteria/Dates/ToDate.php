<?php

namespace IhorOk\QueryCriteria\Criteria\Dates;

use IhorOk\QueryCriteria\Criteria\LessThan;

class ToDate extends LessThan {
	/**
	 * @var string
	 */
	protected $column = 'created_at';
}
