<?php
namespace App\Http\Controllers\Ecommerce;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class ProductsController extends Controller{
	function index(Request $request){
		if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Products',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Products
            $query = DB::table('tbl_products')
                         ->select('tbl_products.id', 'tbl_products_featured_images.featured_image', 'name', 'slug', 'sku_code', 'created_date', 'regural_price', 'sale_price', 'quantity', 'status', 'is_approved', 'from_date', 'to_date')
                         ->leftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_products.id')
                         ->where('tbl_products.user_id', $request->session()->get('user_details')['id'])
                         ->orderBy('tbl_products.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Call Page
            return view('ecommerce.products.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

    function add(Request $request){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Add Product',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Brands
            $query = DB::table('tbl_brands_for_products')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['brands'] = $query->get();

            //Query For Getting Parent Categories
            $query = DB::table('tbl_parent_categories')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['parent_categories'] = $query->get();

            //Call Page
            return view('ecommerce.products.add', $result);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_variations(Request $request){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //initializing Generate data variables
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            //Query For Getting Variation Labels
            $query = DB::table('tbl_variations_for_products')
                         ->select('id', 'value', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result = $query->get();

            //initializing id
            $id = uniqid();

            //initializing html variable
            $html = '';
            if(!empty($result)){
$html .=    '<div class="row main" data-id="'.$id.'">
                <div class="col-md-4 main1">
                    <h5>Variation Information</h5>
                </div>
                <div class="col-md-5 main2"></div>
                <div class="col-md-3 main3">
                    <h5>Avaliability : </h5>
                    <label class="switch">
                        <input type="hidden" name="status[]" id="'.$id.'" value="1">
                        <input type="checkbox" id="status" data-id="'.$id.'" class="form-control">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="col-md-12 contain">
                    <select name="variation[]" id="variation" class="form-control select_2 variation_'.$id.'" style="width:100%" data-id="'.$id.'">
                        <option>Select Variant</option>';
            foreach($result as $options){
              $html .= '<option value="'.$options->id.'">'.$options->value.'</option>';
            }
              $html .= '</select>
                    <a href="javascript::void(0);" id="remove_variation" style="color: red"><i class="fa fa-minus"> Remove</i></a><br><p style="color: red;padding: 1%;margin-top: 2%;margin-bottom: 2%;padding-left: 0%;">Drag and drop pictures below to upload.Multiple images can be uploaded at once.Maximum 6 pictures, size between 650*850 px.</p>
                </div>
                <div class="col-md-12" style="margin-left: 1%; border: 1px solid lightgray; padding: 15px;max-width: 98%;">
                    <div class="image-upload-wrap">
                        <input type="file" id="multi_image" name="product_images[]" multiple data-id="'.$id.'">
                    </div>
                    <div class="file-upload-content">
                        <div class="col-md-12" id="preview_images_'.$id.'">
                            <ul id="sortable" class="sortable_dragable_image_ul preview_images_'.$id.'">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 items1" style="margin-left:1%;max-width: 98%;">
                    <br><div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Product SKU</label><label class="label-control" style="color:red">*</label> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="sku" name="sku[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Quantity</label><label class="label-control" style="color:red">*</label> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="quantity" name="quantity[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Price</label><label class="label-control" style="color:red">*</label> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="price" name="price[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Special Price</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="sale_price" name="sale_price[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Promotion Start Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="'.uniqid().'" name="from[]" class="form-control advertise_datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Promotion End Date</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="'.uniqid().'" name="to[]" class="form-control advertise_datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>';
                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => $html,
                );
                echo json_encode($ajax_response_data);
            }else{
                $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                );
                echo json_encode($ajax_response_data);
            }
            die;
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function get_child_categories(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            $query = DB::table('tbl_child_categories')
                         ->select('id', 'name')
                         ->where('parent_id', $id)
                         ->where('status', 0);
            $result = $query->get();

            $html = '';
            if(!empty($result->count() > 0)){
                foreach($result as $row){
                    $html .= '<option value='.$row->id.'>'.$row->name.'</option>';
                }    

                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => '<option>No child cateogry selected</option>'.$html,
                );

                echo json_encode($ajax_response_data);
            }else{
                $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                );

                echo json_encode($ajax_response_data);
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
        die;
    }

    function get_sub_child_categories(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            $query = DB::table('tbl_sub_child_categories')
                         ->select('id', 'name')
                         ->where('child_id', $id)
                         ->where('status', 0);
            $result = $query->get();

            $html = '';
            if(!empty($result->count() > 0)){
                foreach($result as $row){
                    $html .= '<option value='.$row->id.'>'.$row->name.'</option>';
                }    

                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => '<option>No sub child cateogry selected</option>'.$html,
                );

                echo json_encode($ajax_response_data);
            }else{
                $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                );

                echo json_encode($ajax_response_data);
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
        die;
    }

    function insert(Request $request){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Inputs Validation
            $input_validations = $request->validate([
                'name' => 'required',
                'parent_category' => 'required|numeric',
                'child_category' => 'required|numeric',
                'sub_child_category' => 'required|numeric',
                'brand' => 'required|numeric',
                'high_light' => 'required',
                'description' => 'required',
                'warranty_type' => 'required',
                'weight' => 'required',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'variation.*' => 'required|numeric',
                'product_images.*' => 'required|max:5120',
                'status.*' => 'required',
                'sku.*' => 'required',
                'quantity.*' => 'required|numeric',
                'price.*' => 'required|numeric',
                'sale_price.*' => 'nullable|numeric',
                'from.*' => 'nullable',
                'to.*' => 'nullable',
                'video_url' => 'nullable',
                'meta_keywords' => 'nullable',
                'meta_description' => 'nullable',
                'images.*' => 'required',
                'url.*' => 'required',
            ]);

            if(!empty($request->input('status') && $request->input('variation') && $request->input('product_images') && $request->input('sku') && $request->input('quantity') && $request->input('price') && $request->input('sale_price') && $request->input('from') && $request->input('to'))){
                if(!empty($request->input('variation'))){
                    //Query For Getting Vendor Id
                    $query = DB::table('tbl_store_settings')
                                 ->select('store_name')
                                 ->where('vendor_id', $request->session()->get('user_details')['id']);
                    $vendor_details = $query->first();

                    $count = 0;
                    foreach($request->input('variation') as $row){
                        if($request->input('sale_price')[$count] >= $request->input('price')[$count]){
                            //Flash Error Msg
                            $request->session()->flash('alert-danger', 'Special price must be less than the price.');

                            //Redirect
                            return redirect()->back()->withInput($request->all());
                        }else{
                            if(!empty($request->input('from')[$count] && $request->input('to')[$count])){
                                $from_date = date('Y-m-d', strtotime($request->input('from')[$count]));
                                $to_date = date('Y-m-d', strtotime($request->input('to')[$count]));
                            }else{
                                $from_date = NULL;
                                $to_date = NULL;
                            } 

                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $request->session()->get('user_details')['id'],
                                'name' => $request->input('name'),
                                'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->input('name').'-'.$vendor_details->store_name))),
                                'high_light' => $request->input('high_light'),
                                'description' => $request->input('description'),
                                'warranty_type' => $request->input('warranty_type'),
                                'what_in_the_box' => $request->input('what_in_the_box'),
                                'weight' => $request->input('weight'),
                                'length' => $request->input('length'),
                                'width' => $request->input('width'),
                                'height' => $request->input('height'),
                                'variation_id' => $row,
                                'sku_code' => $request->input('sku')[$count],
                                'regural_price' => $request->input('price')[$count],
                                'sale_price' => $request->input('sale_price')[$count],
                                'quantity' => $request->input('quantity')[$count],
                                'from_date' => $from_date,
                                'to_date' => $to_date,
                                'status' => $request->input('status')[$count],
                                'is_approved' => 1,
                                'meta_keywords' => $request->input('meta_keywords'),
                                'meta_description' => $request->input('meta_description'),
                                'video_url' => $request->input('video_url'),
                                'created_date' => date('Y-m-d'),
                                'created_time' => date('h:i:s'),
                            );

                            //Query For Inserting Data
                            $product_id = DB::table('tbl_products')
                                              ->insertGetId($data);    
                            $count++;

                            foreach($request->input('url')[$row] as $url){
                                //Upload Product Image
                                $image = uniqid().'.jpeg';
                                $image_path = file_put_contents('/var/www/admin.shopker.pk/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($url));
                                
                                //Set Field data according to table columns
                                $data = array(
                                    'ip_address' => $request->ip(),
                                    'user_id' => $request->session()->get('user_details')['id'],
                                    'product_id' => $product_id,
                                    'image' => $image,
                                ); 
                                
                                //Query For Inserting Data
                                $image_id = DB::table('tbl_products_images')
                                                ->insertGetId($data);

                                $pro_images[] = $image; 
                            }
                            
                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $request->session()->get('user_details')['id'],
                                'featured_image' => $pro_images[0],
                                'product_id' => $product_id,
                            );

                            //Query For Inserting Data
                            $brand_id = DB::table('tbl_products_featured_images')
                                            ->insertGetId($data);

                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $request->session()->get('user_details')['id'],
                                'product_id' => $product_id,
                                'brand_id' => $request->input('brand'),
                            );

                            //Query For Inserting Data
                            $brand_id = DB::table('tbl_product_brands')
                                            ->insertGetId($data);

                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $request->session()->get('user_details')['id'],
                                'product_id' => $product_id,
                                'parent_id' => $request->input('parent_category'),
                                'child_id' => $request->input('child_category'),
                                'sub_child_id' => $request->input('sub_child_category'),
                            );

                            //Query For Inserting Data
                            $category_id = DB::table('tbl_product_categories')
                                               ->insertGetId($data);
                        }
                    }

                    if(!empty($category_id)){
                        //Flash Error Msg
                        $request->session()->flash('alert-success', 'Product has been added successfully');
                    }else{
                        $p_id = DB::table('tbl_products')
                                     ->where('id', $product_id)
                                     ->delete();

                        $b_id = DB::table('tbl_product_brands')
                                     ->where('product_id', $product_id)
                                     ->delete();

                        $c_id = DB::table('tbl_product_categories')
                                     ->where('product_id', $product_id)
                                     ->delete();

                        $i_id = DB::table('tbl_products_images')
                                     ->where('product_id', $product_id)
                                     ->delete();
                                     
                        //Flash Erro Msg
                        $request->session()->flash('alert-danger', 'Something went wrong !!');
                    }
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Variation is required for adding products.');
                }
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Variation is required for adding products.');
            }
            
            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_status(Request $request, $id, $status){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $id)){
            if($status == 0){
                $status = 1;
            }elseif($status == 1){
                $status = 0;
            }

            $query = DB::table('tbl_products')
                         ->where('id', $id)
                         ->update(array('status' => $status));

            if(!empty($query == 1)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Status has been updated successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_cost_price(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $id)){
            $query = DB::table('tbl_products')
                         ->select('sale_price')
                         ->where('id', $id);
            $sale_price = $query->first();

            if($request->input('cost_price') <= $sale_price->sale_price){
                //Flash Error Msg
                $request->session()->flash('alert-danger', 'Retail price must be greater than the Sale price.');
            }else{
                //Set Field data according to table columns
                $data = array(
                    'regural_price' => $request->input('cost_price'),
                );
                
                //Query For Updating Data
                $query = DB::table('tbl_products')
                         ->where('id', $id)
                         ->update($data);

                if(!empty($query == 1)){
                    //Flash Erro Msg
                    $request->session()->flash('alert-success', 'Retail Price has been updated successfully');
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Something went wrong !!');
                }
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_sale_price(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $id)){
            $query = DB::table('tbl_products')
                         ->select('regural_price')
                         ->where('id', $id);
            $cost_price = $query->first();
            
            if($request->input('sale_price') >= $cost_price->regural_price){
                //Flash Error Msg
                $request->session()->flash('alert-danger', 'Sale price must be less than the Retail price.');
            }else{
                //Set Field data according to table columns
                $data = array(
                    'sale_price' => $request->input('sale_price'), 
                    'from_date' => $request->input('from_date'), 
                    'to_date' => $request->input('to_date'),
                );
                
                //Query For Updating Data
                $query = DB::table('tbl_products')
                             ->where('id', $id)
                             ->update($data);

                if(!empty($query == 1)){
                    //Flash Erro Msg
                    $request->session()->flash('alert-success', 'Sale Price has been updated successfully');
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Something went wrong !!');
                }
            }
            
            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function ajax_update_quantity(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $id)){
            $query = DB::table('tbl_products')
                         ->where('id', $id)
                         ->update(array('quantity' => $request->input('quantity')));

            if(!empty($query == 1)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Quantity has been updated successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function edit(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $id)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Edit Product',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting this Product details
            $query = DB::table('tbl_products')
                         ->select('*')
                         ->where('id', $id);
            $result['query_product'] = $query->first();

            //Query For Getting brand of this Product
            $query = DB::table('tbl_product_brands')
                         ->select('tbl_brands_for_products.id', 'tbl_brands_for_products.name')
                         ->leftJoin('tbl_brands_for_products', 'tbl_brands_for_products.id', '=', 'tbl_product_brands.brand_id')
                         ->where('tbl_product_brands.product_id', $id)
                         ->where('tbl_product_brands.user_id', $request->session()->get('user_details')['id']);
            $result['query_brand'] = $query->first();

            //Query For Getting Categories of this Product
            $query = DB::table('tbl_product_categories')
                         ->select('tbl_parent_categories.id as p_id', 'tbl_parent_categories.name as p_name', 'tbl_child_categories.id as c_id', 'tbl_child_categories.name as c_name', 'tbl_sub_child_categories.id as s_c_id', 'tbl_sub_child_categories.name as s_c_name')
                         ->leftJoin('tbl_parent_categories', 'tbl_parent_categories.id', '=', 'tbl_product_categories.parent_id')
                         ->leftJoin('tbl_child_categories', 'tbl_child_categories.id', '=', 'tbl_product_categories.child_id')
                         ->leftJoin('tbl_sub_child_categories', 'tbl_sub_child_categories.id', '=', 'tbl_product_categories.sub_child_id')
                         ->where('tbl_product_categories.product_id', $id)
                         ->where('tbl_product_categories.user_id', $request->session()->get('user_details')['id']);
            $result['query_categories'] = $query->first();

            //Query For Getting Images of this Product
            $query = DB::table('tbl_products_images')
                         ->select('*')
                         ->where('product_id', $id)
                         ->where('user_id', $request->session()->get('user_details')['id']);
            $result['query_images'] = $query->get();

            //Query For Getting Brands
            $query = DB::table('tbl_brands_for_products')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['brands'] = $query->get();

            //Query For Getting Parent Categories
            $query = DB::table('tbl_parent_categories')
                         ->select('id', 'name')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['parent_categories'] = $query->get();

            //Query For Getting Child Categories
            $query = DB::table('tbl_child_categories')
                         ->select('id', 'name')
                         ->where('parent_id', $result['query_categories']->p_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['child_categories'] = $query->get();

            //Query For Getting Sub Child Categories
            $query = DB::table('tbl_sub_child_categories')
                         ->select('id', 'name')
                         ->where('child_id', $result['query_categories']->c_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['sub_child_categories'] = $query->get();

            //Query For Getting Variations
            $query = DB::table('tbl_variations_for_products')
                         ->select('id', 'value', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['variations'] = $query->get();
            
            if(!empty($result['query_product'])){
                //call page
                return view('ecommerce.products.edit', $result); 
            }else{
                print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function update(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2 && $id)){
            //Inputs Validation
            $input_validations = $request->validate([
                'name' => 'required',
                'parent_category' => 'required|numeric',
                'child_category' => 'required|numeric',
                'sub_child_category' => 'required|numeric',
                'brand' => 'required|numeric',
                'high_light' => 'required',
                'description' => 'required',
                'warranty_type' => 'required',
                'weight' => 'required',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'variation_id' => 'required|numeric',
                'product_images.*' => 'required|max:5120',
                'status' => 'required',
                'sku' => 'required',
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
                'sale_price' => 'nullable|numeric',
                'from' => 'nullable',
                'to' => 'nullable',
                'video_url' => 'nullable',
                'meta_keywords' => 'nullable',
                'meta_description' => 'nullable',
                'images.*' => 'required',
                'url.*' => 'required',
            ]);
            
            if(!empty($request->input('status') && $request->input('variation') && $request->input('product_images') && $request->input('sku') && $request->input('quantity') && $request->input('price') && $request->input('sale_price') && $request->input('from') && $request->input('to'))){
                if(!empty($request->input('variation'))){
                if(!empty($request->input('variation_id'))){
                    //Query For Getting Vendor Id
                    $query = DB::table('tbl_store_settings')
                                 ->select('store_name')
                                 ->where('vendor_id', $request->session()->get('user_details')['id']);
                    $vendor_details = $query->first();

                    if($request->input('sale_price') >= $request->input('price')){
                        //Flash Error Msg
                        $request->session()->flash('alert-danger', 'Special price must be less than the price.');

                        //Redirect
                        return redirect()->back()->withInput($request->all());
                    }else{
                        $count = 0;
                        foreach($request->input('url')[$request->input('variation_id')] as $url){
                            if(!empty(file_exists(env('ADMIN_URL').'public/assets/admin/images/ecommerce/products/'.$request->input('images')[$request->input('variation_id')][$count]))){
                                $image = $request->input('images')[$request->input('variation_id')][$count];
                            }else{
                                //Upload Product Image
                                $image = uniqid().'.jpeg';
                                $image_path = file_put_contents('/var/www/admin.shopker.pk/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($url));
                            }
                            $pro_images[] = $image;
                            $count++;
                        }

                        if(!empty($request->input('from') && $request->input('to'))){
                            $from_date = date('Y-m-d', strtotime($request->input('from')));
                            $to_date = date('Y-m-d', strtotime($request->input('to')));
                        }else{
                            $from_date = NULL;
                            $to_date = NULL;
                        } 

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('user_details')['id'],
                            'name' => $request->input('name'),
                            'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->input('name').'-'.$vendor_details->store_name))),
                            'high_light' => $request->input('high_light'),
                            'description' => $request->input('description'),
                            'warranty_type' => $request->input('warranty_type'),
                            'what_in_the_box' => $request->input('what_in_the_box'),
                            'weight' => $request->input('weight'),
                            'length' => $request->input('length'),
                            'width' => $request->input('width'),
                            'height' => $request->input('height'),
                            'variation_id' => $request->input('variation_id'),
                            'sku_code' => $request->input('sku'),
                            'regural_price' => $request->input('price'),
                            'sale_price' => $request->input('sale_price'),
                            'quantity' => $request->input('quantity'),
                            'from_date' => $from_date,
                            'to_date' => $to_date,
                            'status' => $request->input('status'),
                            'meta_keywords' => $request->input('meta_keywords'),
                            'meta_description' => $request->input('meta_description'),
                            'video_url' => $request->input('video_url'),
                            'created_date' => date('Y-m-d'),
                            'created_time' => date('h:i:s'),
                        );

                        //Query For Updating Data
                        $product_id = DB::table('tbl_products')
                                     ->where('id', $id)
                                     ->where('user_id', $request->session()->get('user_details')['id'])
                                     ->update($data);

                        //Query For Deleting Previous Images
                        $query = DB::table('tbl_products_images')
                                     ->where('product_id', $id)
                                     ->where('user_id', $request->session()->get('user_details')['id'])
                                     ->delete();

                        foreach($pro_images as $image){
                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $request->session()->get('user_details')['id'],
                                'product_id' => $id,
                                'image' => $image,
                            ); 
                            
                            //Query For Inserting Data
                            $image_id = DB::table('tbl_products_images')
                                            ->insertGetId($data);
                        }

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('user_details')['id'],
                            'featured_image' => $pro_images[0],
                            'product_id' => $id,
                        );

                        //Query For Inserting Data
                        $brand_id = DB::table('tbl_products_featured_images')
                                        ->where('product_id', $id)
                                        ->where('user_id', $request->session()->get('user_details')['id'])
                                        ->update($data);

                        //Set Field data according to table columns
                        $data = array(
                            'user_id' => $request->session()->get('user_details')['id'],
                            'ip_address' => $request->ip(),
                            'brand_id' => $request->input('brand'),
                        );

                        //Query For Updating Data
                        $brand_id = DB::table('tbl_product_brands')
                                        ->where('product_id', $id)
                                        ->where('user_id', $request->session()->get('user_details')['id'])
                                        ->update($data);

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('user_details')['id'],
                            'parent_id' => $request->input('parent_category'),
                            'child_id' => $request->input('child_category'),
                            'sub_child_id' => $request->input('sub_child_category'),
                        );

                        //Query For Updating Data
                        $category_id = DB::table('tbl_product_categories')
                                           ->where('product_id', $id)
                                           ->where('user_id', $request->session()->get('user_details')['id'])
                                           ->update($data);
                    }

                    if(!empty($category_id == 0)){
                        //Flash Erro Msg
                        $request->session()->flash('alert-success', 'Product has been updated successfully');
                    }else{
                        //Flash Erro Msg
                        $request->session()->flash('alert-danger', 'Something went wrong !!');
                    }
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Variation is required for adding products.');
                }
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Variation is required for adding products.');
            }

            //Redirect
            return redirect()->back()->withInput($request->all());
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function duplicate(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Copy Product',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting this Product details
            $query = DB::table('tbl_products')
                         ->select('*')
                         ->where('id', $id);
            $result['query_product'] = $query->first();

            //Query For Getting brand of this Product
            $query = DB::table('tbl_product_brands')
                         ->select('tbl_brands_for_products.id', 'tbl_brands_for_products.name')
                         ->leftJoin('tbl_brands_for_products', 'tbl_brands_for_products.id', '=', 'tbl_product_brands.brand_id')
                         ->where('tbl_product_brands.product_id', $id);
            $result['query_brand'] = $query->first();

            //Query For Getting Categories of this Product
            $query = DB::table('tbl_product_categories')
                         ->select('tbl_parent_categories.id as p_id', 'tbl_parent_categories.name as p_name', 'tbl_child_categories.id as c_id', 'tbl_child_categories.name as c_name', 'tbl_sub_child_categories.id as s_c_id', 'tbl_sub_child_categories.name as s_c_name')
                         ->leftJoin('tbl_parent_categories', 'tbl_parent_categories.id', '=', 'tbl_product_categories.parent_id')
                         ->leftJoin('tbl_child_categories', 'tbl_child_categories.id', '=', 'tbl_product_categories.child_id')
                         ->leftJoin('tbl_sub_child_categories', 'tbl_sub_child_categories.id', '=', 'tbl_product_categories.sub_child_id')
                         ->where('tbl_product_categories.product_id', $id);
            $result['query_categories'] = $query->first();

            //Query For Getting Images of this Product
            $query = DB::table('tbl_products_images')
                         ->select('*')
                         ->where('product_id', $id);
            $result['query_images'] = $query->get();

            //Query For Getting Brands
            $query = DB::table('tbl_brands_for_products')
                         ->select('id', 'name', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['brands'] = $query->get();

            //Query For Getting Parent Categories
            $query = DB::table('tbl_parent_categories')
                         ->select('id', 'name')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['parent_categories'] = $query->get();

            //Query For Getting Child Categories
            $query = DB::table('tbl_child_categories')
                         ->select('id', 'name')
                         ->where('parent_id', $result['query_categories']->p_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['child_categories'] = $query->get();

            //Query For Getting Sub Child Categories
            $query = DB::table('tbl_sub_child_categories')
                         ->select('id', 'name')
                         ->where('child_id', $result['query_categories']->c_id)
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['sub_child_categories'] = $query->get();

            //Query For Getting Variations
            $query = DB::table('tbl_variations_for_products')
                         ->select('id', 'value', 'status')
                         ->where('status', 0)
                         ->orderBy('id', 'DESC');
            $result['variations'] = $query->get();
            
            if(!empty($result['query_product'])){
                //call page
                return view('ecommerce.products.duplicate', $result); 
            }else{
                print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function duplicate_insert(Request $request){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Inputs Validation
            $input_validations = $request->validate([
                'name' => 'required',
                'parent_category' => 'required',
                'child_category' => 'required',
                'sub_child_category' => 'required',
                'brand' => 'required',
                'high_light' => 'required',
                'description' => 'required',
                'warranty_type' => 'required',
                'weight' => 'required',
                'length' => 'nullable|numeric',
                'width' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'variation_id' => 'required',
                'product_images.*' => 'required|max:5120',
                'status' => 'required',
                'sku' => 'required',
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
                'sale_price' => 'nullable|numeric',
                'from' => 'nullable',
                'to' => 'nullable',
                'video_url' => 'nullable',
                'meta_keywords' => 'nullable',
                'meta_description' => 'nullable',
                'images.*' => 'required',
                'url.*' => 'required',
            ]);

            if(!empty($request->input('status') && $request->input('variation') && $request->input('product_images') && $request->input('sku') && $request->input('quantity') && $request->input('price') && $request->input('sale_price') && $request->input('from') && $request->input('to'))){
                if(!empty($request->input('variation_id'))){
                    //Query For Getting Vendor Id
                    $query = DB::table('tbl_store_settings')
                                 ->select('store_name')
                                 ->where('vendor_id', $request->session()->get('user_details')['id']);
                    $vendor_details = $query->first();
                    
                    if($request->input('sale_price') >= $request->input('price')){
                        //Flash Error Msg
                        $request->session()->flash('alert-danger', 'Special price must be less than the price.');

                        //Redirect
                        return redirect()->back()->withInput($request->all());
                    }else{
                        $count = 0;
                        foreach($request->input('url')[$request->input('variation_id')] as $url){
                            //Upload Product Image
                            $image = uniqid().'.jpeg';
                                $image_path = file_put_contents('/var/www/admin.shopker.pk/public/assets/admin/images/ecommerce/products/'.$image, file_get_contents($url));
                            $pro_images[] = $image;
                            $count++;
                        }

                        if(!empty($request->input('from') && $request->input('to'))){
                            $from_date = date('Y-m-d', strtotime($request->input('from')));
                            $to_date = date('Y-m-d', strtotime($request->input('to')));
                        }else{
                            $from_date = NULL;
                            $to_date = NULL;
                        } 

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('user_details')['id'],
                            'name' => $request->input('name'),
                            'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->input('name').'-'.$vendor_details->store_name))),
                            'high_light' => $request->input('high_light'),
                            'description' => $request->input('description'),
                            'warranty_type' => $request->input('warranty_type'),
                            'what_in_the_box' => $request->input('what_in_the_box'),
                            'weight' => $request->input('weight'),
                            'length' => $request->input('length'),
                            'width' => $request->input('width'),
                            'height' => $request->input('height'),
                            'variation_id' => $request->input('variation_id'),
                            'sku_code' => $request->input('sku'),
                            'regural_price' => $request->input('price'),
                            'sale_price' => $request->input('sale_price'),
                            'quantity' => $request->input('quantity'),
                            'from_date' => $from_date,
                            'to_date' => $to_date,
                            'status' => $request->input('status'),
                            'video_url' => $request->input('video_url'),
                            'is_approved' => 1,
                            'meta_keywords' => $request->input('meta_keywords'),
                            'meta_description' => $request->input('meta_description'),
                            'created_date' => date('Y-m-d'),
                            'created_time' => date('h:i:s'),
                        );

                        //Query For Updating Data
                        $product_id = DB::table('tbl_products')
                                     ->insertGetId($data);

                        foreach($pro_images as $image){
                            //Set Field data according to table columns
                            $data = array(
                                'ip_address' => $request->ip(),
                                'user_id' => $request->session()->get('user_details')['id'],
                                'product_id' => $product_id,
                                'image' => $image,
                            ); 
                            
                            //Query For Inserting Data
                            $image_id = DB::table('tbl_products_images')
                                            ->insertGetId($data);
                        }

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('user_details')['id'],
                            'featured_image' => $pro_images[0],
                            'product_id' => $product_id,
                        );

                        //Query For Inserting Data
                        $brand_id = DB::table('tbl_products_featured_images')
                                        ->insertGetId($data);

                        //Set Field data according to table columns
                        $data = array(
                            'user_id' => $request->session()->get('user_details')['id'],
                            'product_id' => $product_id,
                            'ip_address' => $request->ip(),
                            'brand_id' => $request->input('brand'),
                        );

                        //Query For Updating Data
                        $brand_id = DB::table('tbl_product_brands')
                                        ->insertGetId($data);

                        //Set Field data according to table columns
                        $data = array(
                            'ip_address' => $request->ip(),
                            'user_id' => $request->session()->get('user_details')['id'],
                            'parent_id' => $request->input('parent_category'),
                            'child_id' => $request->input('child_category'),
                            'sub_child_id' => $request->input('sub_child_category'),
                            'product_id' => $product_id,
                        );

                        //Query For Updating Data
                        $category_id = DB::table('tbl_product_categories')
                                           ->insertGetId($data);
                    }

                    if(!empty($category_id)){
                        //Flash Erro Msg
                        $request->session()->flash('alert-success', 'Product has been added successfully');
                    }else{
                        //Flash Erro Msg
                        $request->session()->flash('alert-danger', 'Something went wrong !!');
                    }
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Variation is required for adding products.');
                }
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Variation is required for adding products.');
            }
            
            //Redirect
            return redirect()->back()->withInput($request->all());
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function delete(Request $request, $id){
        if(!empty($request->session()->get('user_details')['id'] && $request->session()->get('user_details')['role'] == 2)){
            //Query For Deleting details of this product
            $p_id = DB::table('tbl_products')
                         ->where('id', $id)
                         ->where('user_id', $request->session()->get('user_details')['id'])
                         ->delete();

            //Query for Deleting brand of this product
            $b_id = DB::table('tbl_product_brands')
                         ->where('product_id', $id)
                         ->where('user_id', $request->session()->get('user_details')['id'])
                         ->delete();

            //Query for Deleting categories of this product
            $c_id = DB::table('tbl_product_categories')
                         ->where('product_id', $id)
                         ->where('user_id', $request->session()->get('user_details')['id'])
                         ->delete();

            //Query for Deleting images of this product
            $i_id = DB::table('tbl_products_images')
                         ->where('product_id', $id)
                         ->where('user_id', $request->session()->get('user_details')['id'])
                         ->delete();
            
            if(!empty($i_id && $b_id && $c_id && $i_id)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Product has been deleted successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');
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

            $query = DB::table('tbl_products')
                         ->select('tbl_products.id', 'tbl_products_featured_images.featured_image', 'name', 'slug', 'sku_code', 'created_date', 'regural_price', 'sale_price', 'quantity', 'status', 'is_approved', 'from_date', 'to_date')
                         ->leftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_products.id')
                         ->where('tbl_products.user_id', $request->session()->get('user_details')['id']);
                         if(!empty($request->input('name'))){
                   $query->where('name', 'LIKE', '%'.$request->input('name').'%');
                         }
                         if(!empty($request->input('sku'))){
                   $query->where('sku_code', 'LIKE', '%'.$request->input('sku').'%');
                         }
                   $query->orderBy('id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Call Page
            return view('ecommerce.products.manage', $result);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    } 
}