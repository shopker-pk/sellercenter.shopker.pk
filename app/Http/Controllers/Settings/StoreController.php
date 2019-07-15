<?php
namespace App\Http\Controllers\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class StoreController extends Controller{
   	function manage(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Store Settings',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For getting profile data
            $query = DB::table('tbl_users')
                         ->select('tbl_store_settings.cnic', 'tbl_store_settings.bussiness_name', 'tbl_store_settings.store_name', 'tbl_store_settings.store_email', 'tbl_store_settings.store_phone_no', 'tbl_store_settings.store_cell_no', 'tbl_store_settings.store_address', 'tbl_store_settings.warehouse_address', 'tbl_store_settings.cnic', 'tbl_store_settings.ntn_no', 'tbl_countries.country_code', 'tbl_countries.country_name', 'tbl_cities.id as city_id', 'tbl_cities.name as city_name', 'tbl_stores_bank_details.name as bank_name', 'tbl_stores_bank_details.title as bank_title', 'tbl_stores_bank_details.account_no', 'tbl_stores_bank_details.branch_code', 'tbl_store_images.logo', 'tbl_store_images.banner', 'tbl_store_images.cheque')
                         ->LeftJoin('tbl_store_settings', 'tbl_store_settings.vendor_id', '=', 'tbl_users.id')
                         ->LeftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_users.country_id')
                         ->LeftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id')
                         ->LeftJoin('tbl_stores_bank_details', 'tbl_stores_bank_details.store_id', '=', 'tbl_store_settings.id')
                         ->LeftJoin('tbl_store_images', 'tbl_store_images.store_id', '=', 'tbl_store_settings.id')
                         ->where('tbl_store_settings.vendor_id', $request->session()->get('user_details')['id']); 
     		$result['query'] = $query->first();
     		
     		//Call Page
            return view('settings.store.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function update(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
			//Inputs Validation
	        $input_validations = $request->validate([
	            'bussiness_name' => 'required',
	            'store_name' => 'required',
	            'store_email' => 'required',
	            'store_phone_no' => 'required|min:11|max:13|unique:tbl_store_settings,vendor_id,'.$request->session()->get('user_details')['id'],
	            'store_cell_no' => 'nullable|min:11|max:13|unique:tbl_store_settings,vendor_id,'.$request->session()->get('user_details')['id'],
	            'store_address' => 'required',
	            'warehouse_address' => 'required',
	            'cnic' => 'required',
	            'ntn_no' => 'nullable|min:8|max:9|unique:tbl_store_settings,vendor_id,'.$request->session()->get('user_details')['id'],
	            'bank_title' => 'required',
	            'account_no' => 'required',
	            'bank_name' => 'required',
	            'branch_code' => 'required',
	            'logo_image' => 'nullable|mimes:jpeg,jpg,png|max:2000',
	            'banner_image' => 'nullable|mimes:jpeg,jpg,png|max:2000',
	        ]);

	        //Query For Getting Store Id
	        $query = DB::table('tbl_store_settings')
	                     ->select('id')
	                     ->where('vendor_id', $request->session()->get('user_details')['id']);
         	$store_id = $query->first();

	        if(!empty($request->file('logo_image') && $request->file('banner_image'))){
	        	//File Upload
        		$logo_image = uniqid().'.'.$request->file('logo_image')->guessExtension();
                $image_path = $request->file('logo_image')->move('/var/www/admin.shopker.pk/public/assets/admin/images/stores_logo/', $logo_image);

                //File Upload
        		$banner_image = uniqid().'.'.$request->file('banner_image')->guessExtension();
                $image_path = $request->file('banner_image')->move('/var/www/admin.shopker.pk/public/assets/admin/images/stores_banners/', $banner_image);

                //Set Field data according to table column
		        $store_settings = array(
		        	'ip_address' => $request->ip(),
		        	'bussiness_name' => $request->input('bussiness_name'),
		            'store_name' => $request->input('store_name'),
		        	'store_email' => $request->input('store_email'),
		        	'store_phone_no' => $request->input('store_phone_no'),
		        	'store_cell_no' => $request->input('store_cell_no'),
		        	'store_address' => $request->input('store_address'),
		        	'warehouse_address' => $request->input('warehouse_address'),
		        	'cnic' => $request->input('cnic'),
		        	'ntn_no' => $request->input('ntn_no'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_store_settings')
		    	             ->where('vendor_id', $request->session()->get('user_details')['id'])
		    	             ->update($store_settings);

		        //Set Field data according to table column
		        $store_images = array(
		        	'ip_address' => $request->ip(),
		        	'logo' => $logo_image,
		        	'banner' => $banner_image,
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_store_images')
		    	             ->where('store_id', $store_id->id)
		    	             ->update($store_images);

		        //Set Field data according to table column
		        $store_bank_details = array(
		        	'ip_address' => $request->ip(),
		        	'title' => $request->input('bank_title'),
		        	'account_no' => $request->input('account_no'),
		        	'name' => $request->input('bank_name'),
		        	'branch_code' => $request->input('branch_code'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_stores_bank_details')
		    	             ->where('store_id', $store_id->id)
		    	             ->update($store_bank_details);
        	}elseif(!empty($request->file('banner_image'))){
        		//File Upload
        		$banner_image = uniqid().'.'.$request->file('banner_image')->guessExtension();
                $image_path = $request->file('banner_image')->move('/var/www/admin.shopker.pk/public/assets/admin/images/stores_banners/', $banner_image);

                //Set Field data according to table column
		        $store_settings = array(
		        	'ip_address' => $request->ip(),
		        	'bussiness_name' => $request->input('bussiness_name'),
		            'store_name' => $request->input('store_name'),
		        	'store_email' => $request->input('store_email'),
		        	'store_phone_no' => $request->input('store_phone_no'),
		        	'store_cell_no' => $request->input('store_cell_no'),
		        	'store_address' => $request->input('store_address'),
		        	'warehouse_address' => $request->input('warehouse_address'),
		        	'cnic' => $request->input('cnic'),
		        	'ntn_no' => $request->input('ntn_no'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_store_settings')
		    	             ->where('vendor_id', $request->session()->get('user_details')['id'])
		    	             ->update($store_settings);

		        //Set Field data according to table column
		        $store_images = array(
		        	'ip_address' => $request->ip(),
		        	'banner' => $banner_image,
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_store_images')
		    	             ->where('store_id', $store_id->id)
		    	             ->update($store_images);

		        //Set Field data according to table column
		        $store_bank_details = array(
		        	'ip_address' => $request->ip(),
		        	'title' => $request->input('bank_title'),
		        	'account_no' => $request->input('account_no'),
		        	'name' => $request->input('bank_name'),
		        	'branch_code' => $request->input('branch_code'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_stores_bank_details')
		    	             ->where('store_id', $store_id->id)
		    	             ->update($store_bank_details);
        	}elseif(!empty($request->file('logo_image'))){
        		//File Upload
        		$logo_image  = uniqid().'.'.$request->file('logo_image')->guessExtension();
                $image_path = $request->file('logo_image')->move('/var/www/admin.shopker.pk/public/assets/admin/images/stores_logo/', $logo_image);

                //Set Field data according to table column
		        $store_settings = array(
		        	'ip_address' => $request->ip(),
		        	'bussiness_name' => $request->input('bussiness_name'),
		            'store_name' => $request->input('store_name'),
		        	'store_email' => $request->input('store_email'),
		        	'store_phone_no' => $request->input('store_phone_no'),
		        	'store_cell_no' => $request->input('store_cell_no'),
		        	'store_address' => $request->input('store_address'),
		        	'warehouse_address' => $request->input('warehouse_address'),
		        	'cnic' => $request->input('cnic'),
		        	'ntn_no' => $request->input('ntn_no'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_store_settings')
		    	             ->where('vendor_id', $request->session()->get('user_details')['id'])
		    	             ->update($store_settings);

		        //Set Field data according to table column
		        $store_images = array(
		        	'ip_address' => $request->ip(),
		        	'logo' => $logo_image,
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_store_images')
		    	             ->where('store_id', $store_id->id)
		    	             ->update($store_images);

		        //Set Field data according to table column
		        $store_bank_details = array(
		        	'ip_address' => $request->ip(),
		        	'title' => $request->input('bank_title'),
		        	'account_no' => $request->input('account_no'),
		        	'name' => $request->input('bank_name'),
		        	'branch_code' => $request->input('branch_code'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_stores_bank_details')
		    	             ->where('store_id', $store_id->id)
		    	             ->update($store_bank_details);
        	}elseif(empty($request->file('logo_image') && $request->file('banner_image'))){
        		//Set Field data according to table column
		        $store_settings = array(
		        	'ip_address' => $request->ip(),
		        	'bussiness_name' => $request->input('bussiness_name'),
		            'store_name' => $request->input('store_name'),
		            'store_slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->input('store_name')))),
		        	'store_email' => $request->input('store_email'),
		        	'store_phone_no' => $request->input('store_phone_no'),
		        	'store_cell_no' => $request->input('store_cell_no'),
		        	'store_address' => $request->input('store_address'),
		        	'warehouse_address' => $request->input('warehouse_address'),
		        	'cnic' => $request->input('cnic'),
		        	'ntn_no' => $request->input('ntn_no'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_store_settings')
		    	             ->where('vendor_id', $request->session()->get('user_details')['id'])
		    	             ->update($store_settings);

 		        //Set Field data according to table column
		        $store_bank_details = array(
		        	'ip_address' => $request->ip(),
		        	'title' => $request->input('bank_title'),
		        	'account_no' => $request->input('account_no'),
		        	'name' => $request->input('bank_name'),
		        	'branch_code' => $request->input('branch_code'),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );

		        //Query For Updating Store Settings
		    	$query = DB::table('tbl_stores_bank_details')
		    	             ->where('store_id', $store_id->id)
		    	             ->update($store_bank_details);
        	}
        	
        	//Check if data is updated or not
        	if(!empty($query == 1)){
        		//Flash Success Msg
        		$request->session()->flash('alert-success', 'Store Settings has been updated successfully.');
    		}else{
    			//Flash Error Msg
        		$request->session()->flash('alert-danger', "Something wen't wrong !!.");
    		}

    		//Redirect
	        return redirect()->back();
		}else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}
}