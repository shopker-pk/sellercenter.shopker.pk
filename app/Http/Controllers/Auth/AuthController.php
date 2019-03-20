<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class AuthController extends Controller{
	function sign_in(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
			//Redirect to dashboard
            return redirect()->route('dashboard');
		}else{
			//Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Sign In',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Call Page
            return view('auth.sign-in', $result);
		}	
	}

	function validating_credentials(Request $request){
		if(empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
           //Inputs Validation
            $input_validations = $request->validate([
                'email' => 'required|email|String',
                'password' => 'required|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/',
            ]);

            //check user email and password in table
            $query = DB::table('tbl_users')
                         ->select('id', 'first_name', 'last_name', 'email', 'image', 'role')
                         ->where('email', $request->input('email'))
                         ->where('password', sha1($request->input('password')))
                         ->where('role', 2)
                         ->where('status', 0);
            $result = $query->first();

            //if user data found then sign in else redirect with error msg
            if(!empty($result)){
                //Flash Error Msg
                $request->session()->flash('alert-success', 'You have sign in successfully');
                
                //Set data accordings to table columns
                $data = array(
                    'ip_address' => $request->ip(),
                    'user_id' => $result->id,
                    'status' => 0,
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                );

                //Insert data in table
                $query = DB::table('tbl_login_activities')
                             ->insertGetId($data);

                $data = array(
                    'id' => $result->id,
                    'name' => $result->first_name.' '.$result->last_name,
                    'email' => $result->email,
                    'image' => $result->image,
                    'role' => $result->role,
                );
                
                $request->session()->put('user_details', $data);
                
                //Redirect to dashboard
                return redirect()->route('dashboard');
            }else{
                //Flash Error Msg
                $request->session()->flash('alert-danger', 'You are using wrong credentials for sign in');

                //Redirect to sign up page
                return redirect()->route('vendor_sign_in');
            } 
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function sign_out(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
			//Set data accordings to table columns
            $data = array(
                'ip_address' => $request->ip(),
                'user_id' => $request->session()->get('user_details')['id'],
                'status' => 1,
                'date' => date('Y-m-d'),
                'time' => date('H:i:s'),
            );

            //Insert data in table
            $query = DB::table('tbl_login_activities')
                         ->insertGetId($data);

         	$request->session()->flush();

         	//Flash Success Msg
            $request->session()->flash('alert-success', 'You have been log out successfully');

            return redirect()->route('vendor_sign_in');
		}else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}
}