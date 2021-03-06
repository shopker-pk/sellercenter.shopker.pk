<?php
namespace App\Http\Controllers\Finance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;


class OrdersController extends Controller{
	function manage(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Orders Overview',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Orders Overview Data
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_products.sku_code', 'tbl_orders.product_amount', 'tbl_orders.status as operational_status', 'tbl_orders_invoices.status as payout_status', 'tbl_vendors_commission.type as commission_type', 'tbl_vendors_commission.total_percent as commission_percent')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_vendors_commission', 'tbl_vendors_commission.vendor_id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.seller_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_orders.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();
            
            //Call Page
            return view('finance.orders.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function search(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Search Result',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Orders Overview Data
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_products.sku_code', 'tbl_orders.product_amount', 'tbl_orders.status as operational_status', 'tbl_orders_invoices.status as payout_status', 'tbl_vendors_commission.type as commission_type', 'tbl_vendors_commission.total_percent as commission_percent')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_vendors_commission', 'tbl_vendors_commission.vendor_id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_orders.product_id');
                         if(!empty($request->input('order_no'))){
                   $query->where('tbl_orders.order_no', 'LIKE', '%'.$request->input('order_no').'%'); 
                         }
                         if(!empty($request->input('sku'))){
                   $query->where('tbl_products.sku_code', 'LIKE', '%'.$request->input('sku').'%'); 
                         }
                         if(!empty($request->input('from'))){
                   $query->where('tbl_orders.order_date', '<=', date('Y-m-d', strtotime($request->input('from')))); 
                         }
                         if(!empty($request->input('from'))){
                   $query->where('tbl_orders.order_date', '>=', date('Y-m-d', strtotime($request->input('from')))); 
                         }
                   $query->where('tbl_orders.seller_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_orders.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Call Page
            return view('finance.orders.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}
}