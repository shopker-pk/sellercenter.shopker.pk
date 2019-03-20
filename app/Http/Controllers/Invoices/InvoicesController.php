<?php
namespace App\Http\Controllers\Invoices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class InvoicesController extends Controller{
	function manage(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Invoices',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query for Getting Data
            $query = DB::table('tbl_order_invoices')
                         ->select('tbl_order_invoices.payer_id', 'tbl_order_invoices.transaction_id', 'tbl_order_invoices.total', 'tbl_order_invoices.status as p_status', 'tbl_orders.order_no', 'tbl_orders.status as o_status', 'tbl_orders.payment_method', 'tbl_orders.order_date', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_order_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.seller_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_order_invoices.order_no', 'DESC')
                         ->groupBy('tbl_orders.order_no');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();
            
            //Call Page
            return view('invoices.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function details(Request $request, $order_no){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $order_no)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Invoice Details',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Call Page
            return view('invoices.details', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function print(Request $request, $order_no){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $order_no)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Print  Invoice',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Call Page
            return view('invoices.print', $result);
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

            //Query for Getting Data
            $query = DB::table('tbl_order_invoices')
                         ->select('tbl_order_invoices.payer_id', 'tbl_order_invoices.transaction_id', 'tbl_order_invoices.total', 'tbl_order_invoices.status as p_status', 'tbl_orders.order_no', 'tbl_orders.status as o_status', 'tbl_orders.payment_method', 'tbl_orders.order_date', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_order_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id');
                         if(!empty($request->input('order_no'))){
                   $query->where('tbl_orders.order_no', $request->input('order_no'));
                         }
                         if(!empty($request->input('transaction_id'))){
                   $query->where('tbl_order_invoices.transaction_id', $request->input('transaction_id'));
                         }
                         if(!empty($request->input('payment_type'))){
                   $query->where('tbl_orders.payment_method', $request->input('payment_type'));
                         }
                         if(!empty($request->input('order_status'))){
                   $query->where('tbl_orders.status', $request->input('order_status'));
                         }
                         if(!empty($request->input('payment_status'))){
                   $query->where('tbl_order_invoices.status', $request->input('payment_status'));
                         }
                         if(!empty($request->input('from'))){
                   $query->where('tbl_orders.order_date', date('Y-m-d', strtotime($request->input('from'))));
                         }
                         if(!empty($request->input('to'))){
                   $query->where('tbl_orders.order_date', date('Y-m-d', strtotime($request->input('to'))));
                         }
                   $query->where('tbl_orders.seller_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_order_invoices.order_no', 'DESC')
                         ->groupBy('tbl_orders.order_no');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Call Page
            return view('invoices.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}
}