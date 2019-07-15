<?php

function count_new_orders(){
	//Query For Getting Count Total New Orders
	$query = DB::table('tbl_orders')
	             ->select(DB::raw('COUNT(order_no) as total_new_orders'))
	             ->where('order_date', date('Y-m-d'))
	             ->where('seller_id', Session::get('user_details')['id'])
	             ->groupBy('order_no');
 	$result = $query->first(); 

 	if(!empty($result)){
 		$total_new_orders = $result->total_new_orders;
 	}else{
 		$total_new_orders = 0;
 	}

 	return $total_new_orders;
}