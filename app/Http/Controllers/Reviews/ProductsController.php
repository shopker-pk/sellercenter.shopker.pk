<?php
namespace App\Http\Controllers\Reviews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class ProductsController extends Controller{
	function manage(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Product Reviews',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query for Getting Data
            $query = DB::table('tbl_products_reviews')
                         ->select('tbl_products_reviews.id', 'buyer_stars', 'buyer_comment', 'vendor_stars', 'vendor_comment', 'buyer_review_created_date', 'buyer_review_created_time', 'vendor_review_created_date', 'vendor_review_created_time', 'tbl_products.id as p_id', 'name as product_name', 'first_name', 'last_name')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_products_reviews.product_id')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products_reviews.buyer_id')
                         ->where('tbl_products.user_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_products_reviews.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();
            
            //Call Page
            return view('reviews.products.manage', $result);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
	}

	function reply(Request $request, $id){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $id)){
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
            $query = DB::table('tbl_products_reviews')
                         ->where('id', $id)
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
            $query = DB::table('tbl_products_reviews')
                         ->select('tbl_products_reviews.id', 'buyer_stars', 'buyer_comment', 'vendor_stars', 'vendor_comment', 'buyer_review_created_date', 'buyer_review_created_time', 'vendor_review_created_date', 'vendor_review_created_time', 'tbl_products.id as p_id', 'name as product_name', 'first_name', 'last_name')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_products_reviews.product_id')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products_reviews.buyer_id')
                         ->where('tbl_products.user_id', $request->session()->get('user_details')['id']);
                         if(!empty($request->input('name'))){
                   $query->where('tbl_products.name', 'LIKE', '%'.$request->input('name').'%');
                         }
                         if(!empty($request->input('rating') == 0)){
                   $query->where('tbl_products_reviews.buyer_stars', '!=', NULL)
                         ->where('tbl_products_reviews.buyer_comment', NULL);
                         }elseif(!empty($request->input('rating') == 1)){
                   $query->where('tbl_products_reviews.buyer_stars', NULL)
                         ->where('tbl_products_reviews.buyer_comment', '!=', NULL);
                         }elseif(!empty($request->input('rating') == 2)){
                   $query->where('tbl_products_reviews.buyer_stars', '!=', NULL)
                         ->where('tbl_products_reviews.buyer_comment', '!=', NULL);
                         }
                         if(!empty($request->input('reply') == 0)){
                   $query->where('tbl_products_reviews.vendor_comment', '!=', NULL);
                         }elseif(!empty($request->input('reply') == 1)){
                   $query->where('tbl_products_reviews.vendor_comment', NULL);
                         }
                         if(!empty($request->input('from'))){
                   $query->where('tbl_products_reviews.created_date', date('Y-m-d', strtotime($request->input('from'))));
                         }
                         if(!empty($request->input('to'))){
                   $query->where('tbl_products_reviews.created_date', date('Y-m-d', strtotime($request->input('to'))));
                         }
                   $query->orderBy('tbl_products_reviews.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Call Page
            return view('reviews.products.manage', $result);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
	}
}