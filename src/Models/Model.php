<?php
namespace Dialect\Internetx\Models;
class Model {
	public function __construct($data) {
		foreach($data as $key => $value){
			$this->{$key} = $value;
		}
	}
}