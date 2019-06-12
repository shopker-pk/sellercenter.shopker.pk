<?php
namespace App\Http\Controllers\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class ProfileController extends Controller{
	function manage(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Profile Settings',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For getting profile data
            $query = DB::table('tbl_users')
                         ->select('*')
                         ->where('id', $request->session()->get('user_details')['id']); 
     		$result['query'] = $query->first();

     		//Query For getting user country
            $query = DB::table('tbl_countries')
                         ->select('tbl_countries.country_code', 'tbl_countries.country_name')
                         ->LeftJoin('tbl_users', 'tbl_users.country_id', '=', 'tbl_countries.country_code')
                         ->where('tbl_users.country_id', $result['query']->country_id); 
     		$result['country'] = $query->first();

     		//Query For getting user country
            $query = DB::table('tbl_cities')
                         ->select('tbl_cities.id', 'tbl_cities.name')
                         ->LeftJoin('tbl_users', 'tbl_users.city_id', '=', 'tbl_cities.id')
                         ->where('tbl_users.city_id', $result['query']->city_id); 
     		$result['city'] = $query->first();

     		//Call Page
            return view('settings.profile.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function update(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
			//Inputs Validation
	        $input_validations = $request->validate([
	            'first_name' => 'required',
	            'last_name' => 'required',
	            'address' => 'required',
	            'phone_no' => 'required|min:11|max:13|unique:tbl_users,id,'.$request->session()->get('user_details')['id'],
	            'email' => 'required|unique:tbl_users,id,'.$request->session()->get('user_details')['id'],
	            'image' => 'nullable|mimes:jpeg,jpg,png|max:2000',
	            'password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/',
	            'confirm_password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/|same:password',
	        ]);

	        if(!empty($request->file('image'))){
	        	if(!empty($request->input('confirm_password'))){
	        		//File Upload
	        		$image = uniqid().'.'.$request->file('image')->guessExtension();
	                $image_path = $request->file('image')->move($_SERVER["DOCUMENT_ROOT"].'/shopker_admin/public/assets/admin/images/profile_images/', $image);
		        	
		        	//Set Field data according to table column
			        $data = array(
			        	'ip_address' => $request->ip(),
			        	'first_name' => $request->input('first_name'),
			            'last_name' => $request->input('last_name'),
			        	'address' => $request->input('address'),
			        	'phone_no' => $request->input('phone_no'),
			        	'email' => $request->input('email'),
			        	'image' => $image,
			        	'password' => sha1($request->input('confirm_password')),
			        	'created_date' => date('Y-m-d'),
			        	'created_time' => date('h:i:s'),
			        );

			        //Query For Updating Data
			    	$query = DB::table('tbl_users')
			    	             ->where('id', $request->session()->get('user_details')['id'])
			    	             ->update($data);

		    		//Check if profile has been updated or not
			        if(!empty($query == 1)){
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

				    	//Delete Session
				        $request->session()->flush();

				        //Flash Success Msg
                		$request->session()->flash('alert-success', 'Profile has been updated successfully. Please sign in again with your new password.');

				        //Redirect
				        return redirect()->route('vendor_sign_in');
			        }else{
			        	//Flash Error Msg
                		$request->session()->flash('alert-danger', "Something wen't wrong !!.");

            			//Redirect
				        return redirect()->back()->withInput($request->all());
			        }
				}else{
	        		//File Upload
	        		$image = uniqid().'.'.$request->file('image')->guessExtension();
	                $image_path = $request->file('image')->move($_SERVER["DOCUMENT_ROOT"].'/shopker_admin/public/assets/admin/images/profile_images/', $image);

	        		//Set Field data according to table column
			        $data = array(
			        	'ip_address' => $request->ip(),
			        	'first_name' => $request->input('first_name'),
			            'last_name' => $request->input('last_name'),
			        	'address' => $request->input('address'),
			        	'phone_no' => $request->input('phone_no'),
			        	'email' => $request->input('email'),
			        	'image' => $image,
			        	'created_date' => date('Y-m-d'),
			        	'created_time' => date('h:i:s'),
			        );	

			        //Query For Updating Data
	    			$query = DB::table('tbl_users')
	    	                     ->where('id', $request->session()->get('user_details')['id'])
	    	                     ->update($data);

             		//Check either data updated or not
			     	if(!empty($query == 1)){
			     		//Flash Success Message
			     		$request->session()->flash('alert-success', 'Profile has been updated successfully');
			     	}else{
			     		//Flash Error Message
			     		$request->session()->flash('alert-danger', 'Something went wrong !!');
			     	}
			        
			        return redirect()->back();
				}
	        }else{
	        	if(!empty($request->input('confirm_password'))){
	        		//Set Field data according to table column
			        $data = array(
			        	'ip_address' => $request->ip(),
			        	'first_name' => $request->input('first_name'),
			            'last_name' => $request->input('last_name'),
			        	'address' => $request->input('address'),
			        	'phone_no' => $request->input('phone_no'),
			        	'email' => $request->input('email'),
			        	'password' => sha1($request->input('confirm_password')),
			        	'created_date' => date('Y-m-d'),
			        	'created_time' => date('h:i:s'),
			        );
			        
			        //Query For Updating Data
			    	$query = DB::table('tbl_users')
			    	             ->where('id', $request->session()->get('user_details')['id'])
			    	             ->update($data);

	    			//Check if profile has been updated or not
			        if(!empty($query == 1)){
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

				    	//Delete Session
				        $request->session()->flush();

				        //Flash Success Msg
                		$request->session()->flash('alert-success', 'Profile has been updated successfully. Please sign in again with your new password.');

				        //Redirect
				        return redirect()->route('vendor_sign_in');
			        }else{
			        	//Flash Error Msg
                		$request->session()->flash('alert-danger', "Something wen't wrong !!.");

            			//Redirect
				        return redirect()->bacl()->withInput($request->all());
			        }
			    }else{
	        		//Set Field data according to table column
			        $data = array(
			        	'ip_address' => $request->ip(),
			        	'first_name' => $request->input('first_name'),
			            'last_name' => $request->input('last_name'),
			        	'address' => $request->input('address'),
			        	'phone_no' => $request->input('phone_no'),
			        	'email' => $request->input('email'),
			        	'created_date' => date('Y-m-d'),
			        	'created_time' => date('h:i:s'),
			        );
			        
			        //Query For Updating Data
	    			$query = DB::table('tbl_users')
	    	                     ->where('id', $request->session()->get('user_details')['id'])
	    	                     ->update($data);
	    	                     
                 	//Check either data updated or not
			     	if(!empty($query == 1)){
			     		//Flash Success Message
			     		$request->session()->flash('alert-success', 'Profile has been updated successfully');
			     	}else{
			     		//Flash Error Message
			     		$request->session()->flash('alert-danger', 'Something went wrong !!');
			     	}
			        
			        return redirect()->back();
				}
	        }
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}
}