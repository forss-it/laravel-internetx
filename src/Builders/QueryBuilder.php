<?php
namespace Dialect\Internetx\Builders;

class QueryBuilder extends Builder {
	public $limit = 0;
	public $offset = 0;
	public $children = 0;
	public $queries = [];
	protected $operators = [
		"=" => "EQ",
		"!=" => "NE",
		"like" => "LIKE",
		">" => "GT",
		">=" => "GE",
		"<" => "LT",
		"<=" => "LE",
	];

	protected $operations = [];

	public function __construct($code = '0') {
		$this->code = $code;
	}

	public function limit($limit){
		$this->limit = $limit;
		return $this;
	}

	public function offset($offset){
		$this->offset = $offset;
		return $this;
	}

	public function children($children){
		$this->children = $children;
		return $this;
	}

	public function orWhere($field, $operator = null, $value = null){
		return $this->where($field, $operator, $value, $type = "or");
	}

	public function where($field, $operator = null, $value = null, $type = "and"){
		if($field instanceof \Closure){
			$value = (call_user_func($field, new QueryBuilder()))->queries;
			$this->queries[] = [
				'key' => $type,
				'value' => $value,
			];
			return $this;
		}

		if($operator && !$value){
			$value = $operator;
			$operator = '=';
		}

		$operator = $this->operators[strtolower($operator)];

		if(!$operator){
			throw new Exception("Invalid operator: ", $operator);

		}

		$this->queries[] = [
				'key' => $type,
				'value' => [
					['key' => 'key', 'value' => $field],
					['key' => 'operator', 'value' => $operator],
					['key' => 'value', 'value' => $value]
				]
			];

		return $this;
	}


	public function toXml(){
		$views = [];
		if($this->limit){
			$views[] = [ 'key' => 'limit', 'value' => $this->limit];
		}
		if($this->offset){
			$views[] = [ 'key' => 'offset', 'value' => $this->offset];
		}
		if($this->children){
			$views[] = [ 'key' => 'children', 'value' => $this->children];
		}

		$this->tasks = [
			['key' => 'view', 'value' => $views],
			['key' => 'where', 'value' => $this->queries],
		];

		return Parent::toXml();
	}

	public function get(){
		return $this->sendQuery();
	}

	public function first(){
		return $this->sendQuery()[0];
	}





}