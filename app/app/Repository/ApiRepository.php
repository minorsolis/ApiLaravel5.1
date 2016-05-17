<?php

namespace app\Repository;
use AWS;
use Config;

class ApiRepository{

	/**
	 * [api description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function api($params){

		$function 				= @$params['function'];

		if($function == 'deregisterImage'){
			return ApiRepository::deregisterImage($params);
		
		}elseif($function == 'createImage'){
			return ApiRepository::createImage($params);

		}

	}

	/**
	 * [createImage description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function createImage($params){

	}


	/**
	 * [cleanImages description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function deregisterImage($params){
		$function 						= @$params['function'];
		$total 							= 0;
		$ec2 							= AWS::createClient('ec2');
		$imageRaw 						= $ec2->describeImages(array('Owners'=> array('self') ));
		$awsImageSufix 					= Config::get('api.awsImageSufix');

		$imageArray 					= $imageRaw['Images'];

		if(is_array($imageArray)){
			foreach($imageArray AS $row){
				$imageId 				= @$row['ImageId'];

				$date_from 				= @str_ireplace($awsImageSufix, '', $row['Name'] );
				$date_from 				= date("Ymd", strtotime($date_from));

				if($date_from >= Config::get('api.awsImageDateFrom') ){
					$delete 			= $ec2->deregisterImage( array( 'ImageId' => $imageId ) );
					print_r($delete)."<br />";
					++$total;
				}
			}
		}
		echo "<h3>Total $function = $total</h3>";
	}

}