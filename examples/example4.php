<?php

require_once(dirname(__DIR__).'/vendor/autoload.php');

use BiscuitJoint\BiscuitJoint;
use Phreezer\Storage\CouchDB;

$couch = new CouchDB(array(
	'database'=>'biscuits'
));

$biscuit = new BiscuitJoint($couch);

try{
	// CREATE JOINT
	$biscuit::createJoint(array(
		'parts'=>array('id123','id234'),
		'type'=>'connected'
	));
	// CREATING DUPLICATE JOINT THROWS EXCEPTION
	$biscuit::createJoint(array(
		'parts'=>array('id123','id234'),
		'type'=>'connected'
	));
}
catch(Exception $e){
	echo 'EXCEPTION CAUGHT:'.PHP_EOL;
	echo $e->getMessage().PHP_EOL.PHP_EOL;
}

// DELETE ALL JOINTS ASSOCIATED WITH 'id234'
$biscuit::deleteJoints(array(
	'parts'=>array('id234')
));

var_dump($biscuit::getJoints(array(
	'parts'=>array('id123')
)));
