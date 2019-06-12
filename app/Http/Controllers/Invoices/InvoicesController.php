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
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.payer_id', 'tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as p_status', 'tbl_orders.order_no', 'tbl_orders.status as o_status', 'tbl_orders.payment_method', 'tbl_orders.order_date', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.seller_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_orders_invoices.order_no', 'DESC')
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

            //Query For Getting Data
            $query = DB::table('tbl_site_settings')
                         ->select('tbl_site_settings.title', 'tbl_site_settings.address', 'tbl_site_settings.zip_code', 'tbl_cities.name as city_name', 'tbl_countries.country_name', 'tbl_site_images.footer_image')
                         ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_site_settings.city_id')
                         ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_site_settings.country_id')
                         ->leftJoin('tbl_site_images', 'tbl_site_images.admin_id', '=', 'tbl_site_settings.admin_id');
            $result['header_details'] = $query->first();

            //Query For Getting Invoice Details & Customer Details
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as payment_status', 'tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_orders.status as order_status', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.email', 'tbl_users.phone_no')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->groupBy('tbl_orders.order_no');
            $result['invoice_and_customer_details'] = $query->first();
            
            //Query For Getting Order Products & Amount
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', 'tbl_products.name as product_name', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'))
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_products.id', 'DESC');
            $result['order_details'] = $query->get();   

            //Query For Getting Order Payment Detail
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'), 'tbl_products.regural_price', 'tbl_products.sale_price', DB::raw('tbl_products.regural_price - tbl_orders.product_amount as discount'), 'tbl_shipping_charges.charges as shipping_charges', 'tbl_coupons.discount_offer as discount')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->leftJoin('tbl_shipping_charges', 'tbl_shipping_charges.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_orders_coupons', 'tbl_orders_coupons.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_coupons', 'tbl_coupons.id', '=', 'tbl_orders_coupons.coupon_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_orders.id', 'DESC');
            $payment_details = $query->get();

            $subtotal = 0;
            foreach($payment_details as $row){
                $subtotal += +$row->total_amount;
            }
            if($payment_details[0]->discount){
                $discount = $payment_details[0]->discount;
            }else{
                $discount = '00.00';
            }

            $result['subtotal'] = $subtotal / 2;
            $result['discount'] = $discount;
            $result['shipping_charges'] = $payment_details[0]->shipping_charges;
            $result['total'] = $subtotal / 2 - $payment_details[0]->discount + $payment_details[0]->shipping_charges;
                
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

            //Query For Getting Data
            $query = DB::table('tbl_site_settings')
                         ->select('tbl_site_settings.title', 'tbl_site_settings.address', 'tbl_site_settings.zip_code', 'tbl_cities.name as city_name', 'tbl_countries.country_name', 'tbl_site_images.footer_image')
                         ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_site_settings.city_id')
                         ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_site_settings.country_id')
                         ->leftJoin('tbl_site_images', 'tbl_site_images.admin_id', '=', 'tbl_site_settings.admin_id');
            $result['header_details'] = $query->first();

            //Query For Getting Invoice Details & Customer Details
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as payment_status', 'tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_orders.status as order_status', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.email', 'tbl_users.phone_no')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->groupBy('tbl_orders.order_no');
            $result['invoice_and_customer_details'] = $query->first();
            
            //Query For Getting Order Products & Amount
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', 'tbl_products.name as product_name', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'))
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_products.id', 'DESC');
            $result['order_details'] = $query->get();   

            //Query For Getting Order Payment Detail
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'), 'tbl_products.regural_price', 'tbl_products.sale_price', DB::raw('tbl_products.regural_price - tbl_orders.product_amount as discount'), 'tbl_shipping_charges.charges as shipping_charges', 'tbl_coupons.discount_offer as discount')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->leftJoin('tbl_shipping_charges', 'tbl_shipping_charges.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_orders_coupons', 'tbl_orders_coupons.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_coupons', 'tbl_coupons.id', '=', 'tbl_orders_coupons.coupon_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_orders.id', 'DESC');
            $payment_details = $query->get();

            $subtotal = 0;
            foreach($payment_details as $row){
                $subtotal += +$row->total_amount;
            }
            if($payment_details[0]->discount){
                $discount = $payment_details[0]->discount;
            }else{
                $discount = '00.00';
            }

            $result['subtotal'] = $subtotal / 2;
            $result['discount'] = $discount;
            $result['shipping_charges'] = $payment_details[0]->shipping_charges;
            $result['total'] = $subtotal / 2 - $payment_details[0]->discount + $payment_details[0]->shipping_charges;
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
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.payer_id', 'tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as p_status', 'tbl_orders.order_no', 'tbl_orders.status as o_status', 'tbl_orders.payment_method', 'tbl_orders.order_date', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id');
                         if(!empty($request->input('order_no'))){
                   $query->where('tbl_orders.order_no', $request->input('order_no'));
                         }
                         if(!empty($request->input('transaction_id'))){
                   $query->where('tbl_orders_invoices.transaction_id', $request->input('transaction_id'));
                         }
                         if(!empty($request->input('payment_type'))){
                   $query->where('tbl_orders.payment_method', $request->input('payment_type'));
                         }
                         if(!empty($request->input('order_status'))){
                   $query->where('tbl_orders.status', $request->input('order_status'));
                         }
                         if(!empty($request->input('payment_status'))){
                   $query->where('tbl_orders_invoices.status', $request->input('payment_status'));
                         }
                         if(!empty($request->input('from'))){
                   $query->where('tbl_orders.order_date', date('Y-m-d', strtotime($request->input('from'))));
                         }
                         if(!empty($request->input('to'))){
                   $query->where('tbl_orders.order_date', date('Y-m-d', strtotime($request->input('to'))));
                         }
                   $query->where('tbl_orders.seller_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_orders_invoices.order_no', 'DESC')
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