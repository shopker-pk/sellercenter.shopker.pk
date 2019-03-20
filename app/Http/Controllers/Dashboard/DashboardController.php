<?php
namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class DashboardController extends Controller{
	function index(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Dashboard',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting New Orders
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('COUNT(DISTINCT order_no) as total_orders'))
                         ->whereDate('order_date', date('Y-m-d'))
                         ->groupBy('order_no');
            $result['new_orders'] = $query->first();

            //Query For Getting Total Delivered Orders
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('COUNT(DISTINCT order_no) as total_orders'))
                         ->where('status', 4)
                         ->groupBy('order_no');
            $result['delivered_orders'] = $query->first();

            //Query For Getting Total Canceled Orders
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('COUNT(DISTINCT order_no) as total_orders'))
                         ->where('status', 5)
                         ->groupBy('order_no');
            $result['canceled_orders'] = $query->first();

            //echo '<pre>'; print_r($result['total_orders']); die;
            //Call Page
            return view('dashboard.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}
}