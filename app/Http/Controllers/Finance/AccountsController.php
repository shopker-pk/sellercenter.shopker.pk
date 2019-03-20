<?php
namespace App\Http\Controllers\Finance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class AccountsController extends Controller{
	function manage(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Account Statement',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Call Page
            return view('finance.accounts.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

    function print(Request $request){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
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

            //Call Page
            return view('finance.accounts.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}
}