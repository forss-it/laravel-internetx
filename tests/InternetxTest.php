<?php
use \Dialect\Internetx\Internetx;
use \Dialect\Internetx\TestCase;
use \Dialect\Internetx\Builders\QueryBuilder;
class InternetxTest extends TestCase {
	protected function setUp() {
		parent::setUp();
	}
	/** @test */
	public function it_can_retrive_a_query_builder_for_domains(){
		$builder = Internetx::domain();

		$this->assertEquals(QueryBuilder::class, get_class($builder));
		$this->assertEquals('0105', $builder->code);
		
	}


}