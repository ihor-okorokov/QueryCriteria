<?php

namespace IhorOk\QueryCriteria\Support;

use Illuminate\Support\Str as IlluminateSupportStr;

class Str extends IlluminateSupportStr {
	/**
	 * @param  mixed $value
	 * @param  bool $useCoreEmptyFunction
	 *
	 * @return bool
	 */
	public static function isEmpty(mixed $value, bool $useCoreEmptyFunction = false): bool {
		return $value === '' ||
					 $value === [] ||
					 $value === null ||
					 (is_string($value) && trim($value) === '') ||
					 ($useCoreEmptyFunction && empty($value));
	}
}
