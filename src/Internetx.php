<?php
namespace Dialect\Internetx;

use Dialect\Internetx\Builders\QueryBuilder;

class Internetx {

	public static function domain(){
		$builder = new QueryBuilder();
		$builder->code = '0105';
		return $builder;
	}
}