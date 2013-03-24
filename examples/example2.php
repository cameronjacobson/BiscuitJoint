<?php

require_once(dirname(__DIR__).'/vendor/autoload.php');

use BiscuitJoint\BiscuitJoint;
use Phreezer\Storage\CouchDB;

$couch = new CouchDB(array(
	'database'=>'biscuits'
));

$biscuit = new BiscuitJoint($couch);

// CREATE JOINT
$biscuit::createJoint(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected'
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected'
)));

// DELETE DIFFERENT JOINT
$biscuit::deleteJoints(array(
	'parts'=>array('id234','id321'),
	'type'=>'connected'
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected'
)));

// DELETE JOINT WE JUST CREATED
$biscuit::deleteJoints(array(
	'parts'=>array('id234','id123'),
	'type'=>'connected'
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected'
)));
