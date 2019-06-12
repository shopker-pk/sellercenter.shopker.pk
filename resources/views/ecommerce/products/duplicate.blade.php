@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Duplicate Product
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('add_duplicate_product', $query_product->id) }}">Duplicate Product</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <form action="{{ route('insert_duplicate_product', $query_product->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Name</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Product Name*" value="{{ old('name', $query_product->name) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Product Category</label><label class="label-control" style="color:red">*</label>
                                    <select name="parent_category" id="parent_category" class="form-control select_2" style="width: 100%;">
                                        <option value="">Select Category</option>
                                        @if(!empty($parent_categories))
                                            @foreach($parent_categories as $row)
                                                <option value="{{ $row->id }}" @if(old('parent_category') == $row->id) selected @endif @if($query_categories->p_id == $row->id) selected @endif>{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Product Category</label><label class="label-control" style="color:red">*</label>
                                    <select name="child_category" id="child_category" class="form-control select_2" style="width: 100%;">
                                        <option value="">Select Category</option>
                                        @foreach($child_categories as $row)
                                            <option value="{{ $row->id }}" @if(old('child_category') == $row->id) selected @endif @if($query_categories->c_id == $row->id) selected @endif>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Product Category</label><label class="label-control" style="color:red">*</label>
                                    <select name="sub_child_category" id="sub_child_category" class="form-control select_2" style="width: 100%;">
                                        <option value="">Select Category</option>
                                        @foreach($sub_child_categories as $row)
                                            <option value="{{ $row->id }}" @if(old('sub_child_category') == $row->id) selected @endif @if($query_categories->s_c_id == $row->id) selected @endif>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Brand</label><label class="label-control" style="color:red">*</label>
                                    <select name="brand" id="brand" class="form-control select_2" style="width: 100%;">
                                        <option value="">Select Brand</option>
                                        @if(!empty($brands))
                                            @foreach($brands as $row)
                                                <option value="{{ $row->id }}" @if(old('brand') == $row->id) selected @endif @if($query_brand->id == $row->id) selected @endif>{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product High Light</label><label class="label-control" style="color:red">*</label>
                                    <div class="box-body pad">
                                        <textarea name="high_light" id="high_light" class="form-control wysihtml5" placeholder="Product High Light*" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('high_light', $query_product->high_light) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Description</label><label class="label-control" style="color:red">*</label>
                                    <div class="box-body pad">
                                        <textarea name="description" id="description" class="form-control wysihtml5" placeholder="Product High Light*" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('description', $query_product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Warranty Type</label><label class="label-control" style="color:red">*</label>
                                    <select name="warranty_type" id="warranty_type" class="form-control select_2" style="width: 100%;">
                                        <option @if(old('warranty_type') == '') selected @endif>Select Warranty Type</option>
                                        <option value="0" @if(old('warranty_type') == '0') selected @endif @if($query_product->warranty_type == '0') selected @endif>Brand warranty</option>
                                        <option value="1" @if(old('warranty_type') == '1') selected @endif @if($query_product->warranty_type == '1') selected @endif>International manufacture warranty</option>
                                        <option value="2" @if(old('warranty_type') == '2') selected @endif @if($query_product->warranty_type == '2') selected @endif>International seller warranty</option>
                                        <option value="3" @if(old('warranty_type') == '3') selected @endif @if($query_product->warranty_type == '3') selected @endif>International warranty</option>
                                        <option value="4" @if(old('warranty_type') == '4') selected @endif @if($query_product->warranty_type == '4') selected @endif>Local warranty</option>
                                        <option value="5" @if(old('warranty_type') == '5') selected @endif @if($query_product->warranty_type == '5') selected @endif>Seller Shop warranty</option>
                                        <option value="6" @if(old('warranty_type') == '6') selected @endif @if($query_product->warranty_type == '6') selected @endif>Shopker warranty</option>
                                        <option value="7" @if(old('warranty_type') == '7') selected @endif @if($query_product->warranty_type == '7') selected @endif>No warranty</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What's in the Box</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="what_in_the_box" id="what_in_the_box" class="form-control" placeholder="What's in the Box*" value="{{ old('what_in_the_box', $query_product->what_in_the_box) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Package Weight (KG)</label><label class="label-control" style="color:red">*</label>
                                    <input id="weight" name="weight" class="form-control" placeholder="Weight" value="{{ old('weight', $query_product->weight) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="label-control">Package Dimensions (cm)</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="length" name="length" class="form-control" placeholder="Length" value="{{ old('length', $query_product->length) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="width" name="width" class="form-control" placeholder="Width" value="{{ old('width', $query_product->width) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="height" name="height" class="form-control" placeholder="Height" value="{{ old('height', $query_product->height) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Video Url</label>
                                    <input type="text" name="video_url" id="video_url" class="form-control" placeholder="Product Video Url" value="{{ old('video_url', $query_product->video_url) }}">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id="variations">
                                <div class="row main" data-id="{{ $query_product->id }}">
                                    <div class="col-md-4 main1">
                                        <h5>Variation Information</h5>
                                    </div>
                                    <div class="col-md-5 main2"></div>
                                    <div class="col-md-3 main3">
                                        <h5>Avaliability : </h5>
                                        <label class="switch">
                                            <input type="hidden" name="status" id="{{ $query_product->id }}" value="{{ $query_product->status }}">
                                            <input type="checkbox" id="status" data-id="{{ $query_product->id }}" class="form-control" @if($query_product->status == 0) checked @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 contain">
                                        <select class="form-control select_2 variation_{{ $query_product->id }}" style="width:100%" data-id="{{ $query_product->id }}" disabled>
                                            <option>Select Variant</option>
                                            @foreach($variations as $row)
                                            <option value="{{ $row->id }}" @if($query_product->variation_id == $row->id) selected @endif>{{ $row->value }}</option>
                                            @endforeach
                                        </select>
                                        <p style="color: red;padding: 1%;margin-top: 2%;margin-bottom: 2%;padding-left: 0%;">Drag and drop pictures below to upload.Multiple images can be uploaded at once.Maximum 6 pictures, size between 650*850 px.</p>
                                    </div>
                                    <div class="col-md-12" style="margin-left: 1%; border: 1px solid lightgray; padding: 15px;max-width: 98%;">
                                        <div class="image-upload-wrap">
                                            <input type="file" id="multi_image" name="product_images" multiple data-id="{{ $query_product->id }}">
                                        </div>
                                        <div class="file-upload-content">
                                            <div class="col-md-12" id="preview_images_{{ $query_product->id }}">
                                                <input type="hidden" name="variation" value="{{ $query_product->variation_id }}">
                                                <ul id="sortable" class="sortable_dragable_image_ul preview_images_{{ $query_product->id }}">
                                                    @foreach($query_images as $row)
                                                        <li class="ui-state-default sortable_dragable_image_li remove_image_{{ $row->id }}" style="float:left;">
                                                            <input type="hidden" id="images_{{ $query_product->variation_id }}" name='images[{{ $query_product->variation_id }}][]' value="{{ $row->image }}">
                                                            <input type="hidden" id="url_{{ $query_product->variation_id }}" name="url[{{ $query_product->variation_id }}][]" value="{{ env('ADMIN_URL').'public/assets/admin/images/ecommerce/products/'.$row->image }}">
                                                            <span class="pip">
                                                                <img src="{{ env('ADMIN_URL').'public/assets/admin/images/ecommerce/products/'.$row->image }}" alt="Product Images" style="width:135px; height:110px;"/>
                                                                <span class="remove" id="{{ $query_product->variation_id }}" data-id="remove_image_{{ $row->id }}">Remove</span>
                                                            </span>
                                                        </li>
                                                    @endforeach
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
                                                            <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku', $query_product->sku_code) }}">
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
                                                            <input type="text" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', $query_product->quantity) }}">
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
                                                            <input type="text" id="price" name="price" class="form-control" value="{{ old('price', $query_product->regural_price) }}">
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
                                                            <input type="text" id="sale_price" name="sale_price" class="form-control" value="{{ old('sale_price', $query_product->sale_price) }}">
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
                                                            <input type="text" id="{{ uniqid() }}" name="from" class="form-control advertise_datepicker" style="width: 100%;height: 38px;" value="{{ date('D-M-Y', strtotime($query_product->from_date)) }}">
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
                                                            <input type="text" id="{{ uniqid() }}" name="to" class="form-control advertise_datepicker" style="width: 100%;height: 38px;" value="{{  date('D-M-Y', strtotime($query_product->to_date)) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div><br>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-control">Product Meta Keywords</label>
                                    <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="5" placeholder="Product Meta Keywords">{{ old('meta_keywords', $query_product->meta_keywords) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-control">Product Meta Description</label>
                                    <textarea id="meta_description" name="meta_description" class="form-control" rows="5" placeholder="Product Meta Description">{{ old('meta_description', $query_product->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-11"></div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Add</button>            
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@include('layouts.footer')