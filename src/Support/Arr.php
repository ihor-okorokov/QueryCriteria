<?php

namespace IhorOk\QueryCriteria\Support;

use Illuminate\Support\Arr as IlluminateSupportArr;

class Arr extends IlluminateSupportArr {
	/**
	 * @param  array $array
	 * @param  bool $useCoreEmptyFunction
	 *
	 * @return array
	 */
	public static function withoutEmpty(array $array, bool $useCoreEmptyFunction = false): array {
		return static::where($array, fn($value) => !Str::isEmpty($value, $useCoreEmptyFunction));
	}
}
