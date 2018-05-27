<?php

namespace Dialect\Internetx;


class TestCase extends \Orchestra\Testbench\TestCase
{

	protected function setUp()
	{
		parent::setUp();
	}

	protected function getPackageProviders($app)
	{
		return [InternetxServiceProvider::class];
	}
}
