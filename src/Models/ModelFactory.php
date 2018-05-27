<?php
namespace Dialect\Internetx\Models;

class ModelFactory {
	protected static $models = [
		Domain::class,
	];
	public static function create($name, $data){
		$name = strtolower($name);
		foreach(Self::$models as $model){

			if($model::$_identifier == $name){
				return new $model($data);
			}
		}
		return new Model($data);
	}
}