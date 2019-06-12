@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Store Settings
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_store_settings') }}">Manage Store Settings</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <form action="{{ route('update_store_settings') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Business Name</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="bussiness_name" id="bussiness_name" class="form-control" placeholder="Business Name*" value="{{ old('bussiness_name', $query->bussiness_name) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Store Name</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="store_name" id="store_name" class="form-control" placeholder="Store Name*" value="{{ old('store_name', $query->store_name) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="store_email" id="store_email" class="form-control" placeholder="Email*" value="{{ old('store_email', $query->store_email) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="store_phone_no" id="store_phone_no" class="form-control" placeholder="Phone Number*" value="{{ old('store_phone_no', $query->store_phone_no) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" name="store_cell_no" id="store_cell_no" class="form-control" placeholder="Contact Number" value="{{ old('store_cell_no', $query->store_cell_no) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Store Address</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="store_address" id="store_address" class="form-control" placeholder="Store Address*" value="{{ old('store_address', $query->store_address) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Warehouse Address</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="warehouse_address" id="warehouse_address" class="form-control" placeholder="Warehouse Address*" value="{{ old('warehouse_address', $query->warehouse_address) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CNIC</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="cnic" id="cnic" class="form-control" placeholder="CNIC*" value="{{ old('cnic', $query->cnic) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NTN</label>
                                    <input type="text" name="ntn_no" id="ntn_no" class="form-control" placeholder="NTN" value="{{ old('ntn_no', $query->ntn_no) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label><label class="label-control" style="color:red">*</label>
                                    <select name="country" id="country" class="form-control select_2" disabled style="width: 100%;">
                                        <option value="{{ $query->country_code }}">{{ $query->country_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label><label class="label-control" style="color:red">*</label>
                                    <select name="city" id="city" class="form-control select_2" disabled style="width: 100%;">
                                        <option value="{{ $query->city_id }}">{{ $query->city_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank Title</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="bank_title" id="bank_title" class="form-control" placeholder="Bank Title*" value="{{ old('bank_title', $query->bank_title) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank Account NO#</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="account_no" id="account_no" class="form-control" placeholder="Bank Account NO#*" value="{{ old('account_no', $query->account_no) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank Name</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name*" value="{{ old('bank_name', $query->bank_name) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank Branch Code</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="branch_code" id="branch_code" class="form-control" placeholder="Bank Branch Code*" value="{{ old('branch_code', $query->branch_code) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Store Logo</label><br>
                                    <input type="file" id="single_image" name="logo_image" data-id="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Image Preview</label><br>
                                    @if(!empty($query->logo))
                                        <img src="{{ env('ADMIN_URL').'public/assets/admin/images/stores_logo/'.$query->logo }}" class="single_image_preview_1" alt="Store Logo" style="width:150px; height:150px"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Store Banner</label><br>
                                    <input type="file" id="single_image" name="banner_image" data-id="2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Image Preview</label><br>
                                    @if(!empty($query->banner))
                                        <img src="{{ env('ADMIN_URL').'public/assets/admin/images/stores_banners/'.$query->banner }}" class="single_image_preview_2" alt="Store Logo" style="width:150px; height:150px"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Cheque Image</label><br>
                                    <input type="file" id="single_image" name="cheque_image" data-id="3" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Image Preview</label><br>
                                    @if(!empty($query->cheque))
                                        <img src="{{ env('ADMIN_URL').'public/assets/admin/images/cheque_images/'.$query->cheque }}" class="single_image_preview_3" alt="Store Logo" style="width:150px; height:150px"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-11"></div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Submit</button>            
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@include('layouts.footer')