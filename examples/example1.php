<?php

require_once(dirname(__DIR__).'/vendor/autoload.php');

use BiscuitJoint\BiscuitJoint;
use Phreezer\Storage\CouchDB;

$couch = new CouchDB(array(
	'database'=>'biscuits'
));

$biscuit = new BiscuitJoint($couch);

$biscuit::createJoint(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected'
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected'
)));

$biscuit::deleteJoints(array(
	'parts'=>array('id123'),
	'type'=>'connected'
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123','id234'),
	'type'=>'connected'
)));

