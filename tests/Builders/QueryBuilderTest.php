<?php
use \Dialect\Internetx\Builders\QueryBuilder;
use \Dialect\Internetx\TestCase;
class QueryBuilderTest extends TestCase {
	protected function setUp() {
		parent::setUp();
	}

	/** @test */
	public function it_can_set_limit() {
		$builder = new QueryBuilder();

		$builder->limit(500);
		$this->assertEquals($builder->limit, 500);
	}

	/** @test */
	public function it_can_set_offset() {
		$builder = new QueryBuilder();

		$builder->offset(500);
		$this->assertEquals($builder->offset, 500);
	}

	/** @test */
	public function it_can_set_children() {
		$builder = new QueryBuilder();

		$builder->children(5);
		$this->assertEquals($builder->children, 5);
	}
	/** @test */
	public function it_can_query_with_where(){
		$builder = new QueryBuilder();
		$builder->where('test', '=', 'value');

		$this->assertEquals($builder->queries, [['key' => 'and', 'value' => [
			['key' => 'key', 'value' => 'test'],
			['key' => 'operator', 'value' => 'EQ'],
			['key' => 'value', 'value' => 'value'],
		]]]);
	}

	/** @test */
	public function it_can_query_with_orwhere(){
		$builder = new QueryBuilder();
		$builder->orWhere('test', '=', 'value');

		$this->assertEquals($builder->queries, [['key' => 'or', 'value' => [
			['key' => 'key', 'value' => 'test'],
			['key' => 'operator', 'value' => 'EQ'],
			['key' => 'value', 'value' => 'value'],
		]]]);
	}

	/** @test */
	public function it_takes_set_attributes_into_account_when_creating_xml(){
		$builder = new QueryBuilder();
		$builder->limit(100)->offset(200)->children(300)->where('test', 'value');

		$builder->toXml();

		$array = [
			[
				'key' => 'view',
				'value' => [
					['key' => 'limit', 'value' => 100],
					['key' => 'offset', 'value' => 200],
					['key' => 'children', 'value' => 300]
				]
			],
			[
				'key' => 'where',
				'value' => [
					['key' => 'and', 'value' => [
						['key' => 'key', 'value' => 'test'],
						['key' => 'operator', 'value' => 'EQ'],
						['key' => 'value', 'value' => 'value'],
					]],
				]
			]
		];

		$this->assertEquals($builder->tasks, $array);
	}

}