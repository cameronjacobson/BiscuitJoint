<?php

require_once(dirname(__DIR__).'/vendor/autoload.php');

use BiscuitJoint\BiscuitJoint;
use Phreezer\Storage\CouchDB;

$couch = new CouchDB(array(
	'database'=>'biscuits'
));

$biscuit = new BiscuitJoint($couch);

// CREATE ASYMMETRIC JOINT SO PART A KNOWS ABOUT PART B
//  BUT NOT VICE-VERSA
$biscuit::createJoint(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected',
	'symmetric'=>false
));

// id123 KNOWS RELATIONSHIP TO id234
var_dump($biscuit::getJoints(array(
	'parts'=>array('id123')
)));

// id 234 DOES NOT KNOW RELATIONSHIP TO id123
var_dump($biscuit::getJoints(array(
	'parts'=>array('id234')
)));

// DELETE ALL JOINTS ASSOCIATED WITH 'id123'
$biscuit::deleteJoints(array(
	'parts'=>array('id123')
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123')
)));
