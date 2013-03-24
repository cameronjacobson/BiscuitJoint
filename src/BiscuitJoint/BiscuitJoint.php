<?php

namespace BiscuitJoint;

use \BiscuitJoint\JointDefinition;
use \Exception;
use \stdClass;
use \Phreezer\Storage\CouchDB;
use\Phreezer\Phreezer;

class BiscuitJoint
{
	private static $couch;

	public function __construct(CouchDB $couch = null){
		if(empty(self::$couch) && empty($couch)){
			throw new Exception('No couchdb handle provided');
		}
		self::$couch = empty($couch) ? self::$couch : $couch;
	}

	public static function deleteJoints(Array $options){
		$phreezer = new Phreezer();
		$results = self::getJoints($options, 'thaw');
		foreach($results as $uuid=>$obj){
			$obj->_delete = true;
			self::$couch->store($obj);
		}
	}

	public static function createJoint(Array $options){
		if(count(@$options['parts']) !== 2 OR empty($options['type'])){
			throw new Exception('Invalid Request: BiscuitJoint::createJoint()');
		}
		if(self::isDuplicate($options)){
			throw new Exception('Duplicate Joint Definition');
		}
		$joint = new JointDefinition();
		$joint->partA = array_shift($options['parts']);
		$joint->partB = array_shift($options['parts']);
		$joint->type = $options['type'];
		if(isset($options['symmetric'])){
			$joint->setSymmetry($options['symmetric']);
		}
		self::$couch->store($joint);
	}

	public static function isDuplicate(Array $options){
		$joints = self::getJoints($options,'id_only');
		return count($joints['rows']) > 0;
	}

	public static function getJoints(Array $options, $override_filter = null){
		if(empty($options['parts'][0])){
			throw new Exception('Invalid Request: BiscuitJoint::getJoints()');
		}
		$keys = array(array(),array());
		$keys[0][] = $keys[1][] = $options['parts'][0];
		$keys[0][] = empty($options['type']) ? '' : $options['type'];
		$keys[1][] = empty($options['type']) ? new stdClass() : $options['type'];
		$keys[0][] = empty($options['parts'][1]) ? '' : $options['parts'][1];
		$keys[1][] = empty($options['parts'][1]) ? new stdClass() : $options['parts'][1];

		$query_params = array(
            'query'=>array(
                'startkey'=>json_encode($keys[0]),
				'endkey'=>json_encode($keys[1])
            ),
			'debug'=>true,
            'opts'=>array(
                'filter'=>$override_filter ?: 'docstate_only',
                'blacklist'=>array('__phreezer_hash')
            )
		);

		if($override_filter == 'thaw'){
			$query_params['opts'] = array('thaw'=>true);
			$query_params['include_docs'] = 'true';
		}

		return self::$couch->_view->query('all_joints',$query_params);
	}
}
