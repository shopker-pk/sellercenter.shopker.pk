@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Profile Settings
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_profile_settings') }}">Manage Profile Settings</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <form action="{{ route('update_profile_settings') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name*" value="{{ old('first_name', $query->first_name) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name*" value="{{ old('last_name', $query->last_name) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email*" value="{{ old('email', $query->email) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label><label class="label-control" style="color:red">*</label>
                                    <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Phone Number*" readonly value="{{ old('phone_no', $query->phone_no) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label><label class="label-control" style="color:red">*</label>
                                    <textarea type="text" name="address" id="address" class="form-control" placeholder="Address" rows="5">{{ old('address', $query->address) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label><label class="label-control" style="color:red">*</label>
                                    <select name="country" id="country" class="form-control select_2" disabled style="width: 100%;">
                                        <option value="{{ $country->country_code }}">{{ $country->country_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label><label class="label-control" style="color:red">*</label>
                                    <select name="city" id="city" class="form-control select_2" disabled style="width: 100%;">
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Profile Image</label><br>
                                    <input type="file" id="single_image" name="image" data-id="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-control">Image Preview</label><br>
                                    @if(!empty($query->image))
                                        <img src="{{ env('ADMIN_URL').'public/assets/admin/images/profile_images/'.$query->image }}" class="single_image_preview_1" alt="Profile Image" style="width:150px; height:150px"/>
                                    @else
                                        <img class="single_image_preview_1" alt="Profile Image" style="width:150px; height:150px"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-11"></div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Update</button>            
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@include('layouts.footer')