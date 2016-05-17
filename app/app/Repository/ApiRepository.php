<?php

namespace app\Repository;
use AWS;

class ApiRepository{

	/**
	 * [api description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function api($params){

		$ec2 			= AWS::createClient('ec2');
		dd($ec2);
	}

}