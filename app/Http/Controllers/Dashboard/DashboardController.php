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

            //Query For Counting All Products
            $query = DB::table('tbl_products')
                         ->select(DB::raw('count(id) as total_products'))
                         ->where('user_id', $request->session()->get('user_details')['id']);
            $result['total_products'] = $query->first();

            //Query For Counting All Customers
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('count(buyer_id) as total_users'))
                         ->where('seller_id', $request->session()->get('user_details')['id'])
                         ->groupBy('order_no');
            $result['total_users'] = $query->first();

            //Query For Counting All New Orders
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('count(order_no) as new_orders'))
                         ->where('order_date', date('Y-m-d'))
                         ->where('seller_id', $request->session()->get('user_details')['id'])
                         ->groupBy('order_no');
            $result['total_new_orders'] = $query->first();

            //Query For Calculating Total Earning
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('SUM(product_amount * quantity) as total_earning'))
                         ->where('seller_id', $request->session()->get('user_details')['id']);
            $result['total_earning'] = $query->first();

            //Call Page
            return view('dashboard.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

    function monthly_sales(Request $request){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //initializing Generate data variables
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            //Query For Getting Sales By Month
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('SUM(product_amount * quantity) as total_sales'), DB::raw('MONTHNAME(order_date) as months'))
                         ->where('seller_id', $request->session()->get('user_details')['id'])
                         ->groupBy(DB::raw('MONTH(order_date)'))
                         ->orderBy('order_date', 'DESC');
            $result = $query->get();

            if(!empty($result)){
                foreach($result as $row){
                    $data[] = array(
                        'month' => $row->months,
                        'sale' => $row->total_sales,
                    );
                }

                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => $data,
                );
            }else{
                $data = array(
                    'month' => date('M'),
                    'sale' => '00',
                );

               $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => $data,
                ); 
            }

            echo json_encode($ajax_response_data);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}