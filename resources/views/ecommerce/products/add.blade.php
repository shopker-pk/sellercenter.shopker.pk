@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Add Product
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('add_product') }}">Add Product</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <form action="{{ route('insert_product') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Name</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Product Name*" value="{{ old('name') }}">
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
                                                <option value="{{ $row->id }}" @if(old('parent_category') == $row->id) selected @endif>{{ $row->name }}</option>
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Product Category</label><label class="label-control" style="color:red">*</label>
                                    <select name="sub_child_category" id="sub_child_category" class="form-control select_2" style="width: 100%;">
                                        <option value="">Select Category</option>
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
                                                <option value="{{ $row->id }}" @if(old('brand') == $row->id) selected @endif>{{ $row->name }}</option>
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
                                        <textarea name="high_light" id="high_light" class="form-control wysihtml5" placeholder="Product High Light*" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('high_light') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Description</label><label class="label-control" style="color:red">*</label>
                                    <div class="box-body pad">
                                        <textarea name="description" id="description" class="form-control wysihtml5" placeholder="Product High Light*" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('description') }}</textarea>
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
                                        <option value="0" @if(old('warranty_type') == '0') selected @endif>Brand warranty</option>
                                        <option value="1" @if(old('warranty_type') == '1') selected @endif>International manufacture warranty</option>
                                        <option value="2" @if(old('warranty_type') == '2') selected @endif>International seller warranty</option>
                                        <option value="3" @if(old('warranty_type') == '3') selected @endif>International warranty</option>
                                        <option value="4" @if(old('warranty_type') == '4') selected @endif>Local warranty</option>
                                        <option value="5" @if(old('warranty_type') == '5') selected @endif>Seller Shop warranty</option>
                                        <option value="6" @if(old('warranty_type') == '6') selected @endif>Shopker warranty</option>
                                        <option value="7" @if(old('warranty_type') == '7') selected @endif>No warranty</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>What's in the Box</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="what_in_the_box" id="what_in_the_box" class="form-control" placeholder="What's in the Box*" value="{{ old('what_in_the_box') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Package Weight (KG)</label><label class="label-control" style="color:red">*</label>
                                    <input id="weight" name="weight" class="form-control" placeholder="Weight" value="{{ old('weight') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="label-control">Package Dimensions (cm)</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="length" name="length" class="form-control" placeholder="Length" value="{{ old('length') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="width" name="width" class="form-control" placeholder="Width" value="{{ old('width') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="height" name="height" class="form-control" placeholder="Height" value="{{ old('height') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <a href="javascript::void(0);" id="add_variations"><i class="fa fa-plus"></i> Add Product Variations</a>
                                    </div>
                                </div>
                            </div>
                            <div id="variations"></div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-control">Product Meta Keywords</label>
                                    <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="5" placeholder="Product Meta Keywords">{{ old('meta_keywords') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-control">Product Meta Description</label>
                                    <textarea id="meta_description" name="meta_description" class="form-control" rows="5" placeholder="Product Meta Description">{{ old('meta_description') }}</textarea>
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