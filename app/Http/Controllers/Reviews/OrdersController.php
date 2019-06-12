<?php
namespace App\Http\Controllers\Reviews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class OrdersController extends Controller{
	function manage(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Order Reviews',
                'meta_keywords' => '',
                'meta_description' => '',
            );
            
            //Query for Getting Data
            $query = DB::table('tbl_orders_reviews')
                         ->select('tbl_orders_reviews.id', 'tbl_orders.order_no', 'tbl_users.first_name', 'tbl_users.last_name', 'buyer_stars', 'vendor_stars', 'buyer_comment', 'vendor_comment', 'buyer_review_created_date', 'buyer_review_created_time', 'vendor_review_created_date', 'vendor_review_created_time')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_reviews.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders_reviews.buyer_id')
                         ->where('tbl_orders.seller_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_orders_reviews.id', 'DESC')
                         ->groupBy('tbl_orders.order_no');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Call Page
            return view('reviews.orders.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function reply(Request $request, $order_no){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $order_no)){
            if(!empty($request->input('comment'))){
                $vendor_comment = $request->input('comment');
            }else{
                $vendor_comment = ' ';
            }

            //Set Field data according to table column
            $data = array(
                'vendor_comment' => $vendor_comment,
            );

            //Query For Updating Data
            $query = DB::table('tbl_orders_reviews')
                         ->where('order_no', $order_no)
                         ->update($data);

            if(!empty($query)){
                //Flash Success Msg
                $request->session()->flash('alert-success', 'Reply has been added successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', "Something wen't wrong");
            }

            //Redirect
            return redirect()->back();
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
            $query = DB::table('tbl_orders_reviews')
                         ->select('tbl_orders_reviews.id', 'tbl_orders.order_no', 'tbl_users.first_name', 'tbl_users.last_name', 'buyer_stars', 'vendor_stars', 'buyer_comment', 'vendor_comment', 'buyer_review_created_date', 'buyer_review_created_time', 'vendor_review_created_date', 'vendor_review_created_time')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_reviews.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders_reviews.buyer_id')
                         ->where('tbl_orders.seller_id', $request->session()->get('user_details')['id']);
                         if(!empty($request->input('order_no'))){
                   $query->where('tbl_orders_reviews.order_no', $request->input('order_no'));
                         }
                         if(!empty($request->input('rating') == 0)){
                   $query->where('tbl_orders_reviews.buyer_stars', '!=', NULL)
                         ->where('tbl_orders_reviews.buyer_comment', NULL);
                         }elseif(!empty($request->input('rating') == 1)){
                   $query->where('tbl_orders_reviews.buyer_stars', NULL)
                         ->where('tbl_orders_reviews.buyer_comment', '!=', NULL);
                         }elseif(!empty($request->input('rating') == 2)){
                   $query->where('tbl_orders_reviews.buyer_stars', '!=', NULL)
                         ->where('tbl_orders_reviews.buyer_comment', '!=', NULL);
                         }
                         if(!empty($request->input('reply') == 0)){
                   $query->where('tbl_orders_reviews.vendor_comment', '!=', NULL);
                         }elseif(!empty($request->input('reply') == 1)){
                   $query->where('tbl_orders_reviews.vendor_comment', NULL);
                         }
                         if(!empty($request->input('from'))){
                   $query->where('tbl_orders_reviews.created_date', date('Y-m-d', strtotime($request->input('from'))));
                         }
                         if(!empty($request->input('to'))){
                   $query->where('tbl_orders_reviews.created_date', date('Y-m-d', strtotime($request->input('to'))));
                         }
                   $query->orderBy('tbl_orders_reviews.id', 'DESC')
                         ->groupBy('tbl_orders.order_no');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Call Page
            return view('reviews.orders.manage', $result);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
	}
}