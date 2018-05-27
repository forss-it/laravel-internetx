<?php
use \Dialect\Internetx\Builders\Builder;
use \Dialect\Internetx\TestCase;
class BuilderTest extends TestCase
{
	protected function setUp() {
		parent::setUp();
	}

	/** @test */
	public function it_can_set_auth(){
		$builder = new Builder();

		$builder->auth('username', 'password');
		$this->assertEquals($builder->username, 'username');
		$this->assertEquals($builder->password, 'password');
	}

	/** @test */
	public function it_can_set_context(){
		$builder = new Builder();

		$builder->context('context');
		$this->assertEquals($builder->context, 'context');
	}

	/** @test */
	public function it_can_convert_builder_to_xml(){
		$builder = new Builder();
		$this->assertNotNull($builder->toXml());
	}

	/** @test */
	public function it_uses_default_auth_from_config(){
		$this->app['config']->set('internetx.auth.username', 'usr');
		$this->app['config']->set('internetx.auth.password', 'pass');
		$builder = new Builder();
		$this->assertEquals($builder->username, 'usr');
		$this->assertEquals($builder->password, 'pass');
	}

	/** @test */
	public function it_can_send_query(){
		$this->markTestSkipped();
	}
}