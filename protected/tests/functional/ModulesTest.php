<?php

class ModulesTest extends WebTestCase
{
	public $fixtures=array(
		'modules'=>'Modules',
	);

	public function testShow()
	{
		$this->open('?r=modules/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=modules/create');
	}

	public function testUpdate()
	{
		$this->open('?r=modules/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=modules/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=modules/index');
	}

	public function testAdmin()
	{
		$this->open('?r=modules/admin');
	}
}
