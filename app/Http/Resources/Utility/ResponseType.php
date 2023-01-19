<?php

namespace App\Http\Resources\Utility;

use Dev\Application\Utility\UserStatus;
use Dev\Application\Exceptions\InvalidArgumentException;
use Dev\Application\Utility\UserType;

/**
 *
 */
final class ResponseType
{
	/**
	 *
	 */
	public static function simpleResponse(string $message, bool $success, array $aux = [])
	{
		return array_merge([
			"data" => [],
			"message" => $message,
			"success" => $success
		], $aux);
	}
}
