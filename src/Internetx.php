<?php
namespace Dialect\Internetx;

use Dialect\Internetx\Builders\QueryBuilder;

class Internetx {
    private static $errorMessage = '';
    public static function setErrorMessage($message)
    {
        self::$errorMessage = $message;
    }
    public static function getLastErrorMessage()
    {
        return self::$errorMessage;
    }

	public static function domain($name = ''){
		$builder = new QueryBuilder();
		$builder->code = '0105';
        if(!empty($name)) {
            $builder->tasks[] = [
                'key' => 'domain',
                'value' => [
                    ['key' => 'name', 'value' => $name]
                ],
            ];
        }
		return $builder;
	}

}