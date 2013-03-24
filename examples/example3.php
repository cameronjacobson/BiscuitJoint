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

// CREATE ANOTHER JOINT
$biscuit::createJoint(array(
	'parts'=>array('id123','id235'),
	'type'=>'connected'
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123')
)));

// DELETE ALL JOINTS ASSOCIATED WITH 'id234'
$biscuit::deleteJoints(array(
	'parts'=>array('id234')
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123')
)));

// DELETE ALL JOINTS ASSOCIATED WITH 'id123'
$biscuit::deleteJoints(array(
	'parts'=>array('id123')
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123')
)));
