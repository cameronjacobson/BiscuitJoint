<?php

namespace BiscuitJoint;

class JointDefinition
{
	const symmetric = true;
	const asymmetric = false;

	private $symmetric = self::symmetric;

	public $partA;
	public $partB;
	public $type;
	public $names;

	public function __construct(){
		
	}

	public function setSymmetry($symmetry){
		$this->symmetric = (bool)$symmetry;
	}
}
