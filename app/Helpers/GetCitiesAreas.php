<?php

function get_cities_areas($city_id){
	//Getting Data from file
	$file = file_get_contents('http://cod.callcourier.com.pk/api/callcourier/GetAreasByCity?CityID='.$city_id);
	$result = json_decode($file, true);

	if(count($result) > 0){
		$ajax_response_data = array(
            'ERROR' => 'FALSE',
            'DATA' => '',
        );

		foreach($result as $row){
			$data[] = array(
				'area_id' => $row['AreaID'],
				'area_name' => $row['AreaName'],
			);
		}
		
		return $data;
	}
}