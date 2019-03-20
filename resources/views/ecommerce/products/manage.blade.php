@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Products
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_products') }}">Manage Products</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header">
                        <form action="{{ route('search_products') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-2">
                                    <input type="text" id="name" name="name" class="form-control pull-right" placeholder="Name">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="sku" name="sku" class="form-control pull-right" placeholder="SKU">
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                    <div class="input-group-btn">
                                        <a href="{{ route('add_product') }}" class="btn btn-default"><i class="fa fa-plus"></i> Add</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Created At</th>
                                    <th>Retail Price</th>
                                    <th>Sale Price</th>
                                    <th>Available</th>
                                    <th>Visible</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                @if(!empty($query))
                                    <input type="hidden" value="{{ $count = 0 }}">
                                    <div class="show_featured_image"></div>
                                    @foreach($query as $row)
                                        <tr>
                                            <td><span class="featured_image" data-id="{{ $count }}">{{ $row->name }}</span></td>
                                            <td>{{ $row->sku_code }}</td>
                                            <td>{{ date('D-M-Y', strtotime($row->created_date)) }}</td>
                                            <td><a href="javascript::void(0);" class="cost_price" data-id="{{ $count }}">{{ $row->regural_price }}</a></td>
                                            <td><a href="javascript::void(0);" class="sale_price" data-id="{{ $count }}">{{ $row->sale_price }}</a></td>
                                            <td><a href="javascript::void(0);" class="quantity" data-id="{{ $count }}">{{ $row->quantity }}</a></td>
                                            <td>
                                                @if($row->is_approved == 0)
                                                    <img src="{{ asset('public/assets/images/icons/check.png') }}" style="height: 25px;width: 30px;">
                                                @else
                                                    <img src="{{ asset('public/assets/images/icons/cross.png') }}" style="height: 25px;width: 30px;">
                                                @endif
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="hidden" name="status[]" id="{{ $row->id }}" value="{{ $row->status }}">
                                                    <a href="{{ url('/vendor/ecommerce/products/ajax/update-status/'. $row->id.'/'. $row->status) }}">
                                                        <input type="checkbox" id="status" data-id="{{ $row->id }}" class="form-control" @if($row->status == 0) checked @endif>
                                                        <span class="slider"></span>
                                                    </a>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
                                                    <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{ route('add_duplicate_product', $row->id) }}">Copy Listing</a></li>
                                                        <li><a href="{{ route('edit_product', $row->id) }}">Edit</a></li>
                                                        <li><a href="{{ route('delete_product', $row->id) }}">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <input type="hidden" value="{{ $count++ }}">
                                    @endforeach
                                @else
                                    No records found !!
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $query->links() }}
                    @if(!empty($query))
                        <input type="hidden" value="{{ $count = 0 }}">
                        @foreach($query as $row)
                            <!-- Update Retail Price -->
                            <div class="modal fade text-left" id="cost_price_modal_{{ $count }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Product Name : {{ $row->name }}</label>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('ajax_update_cost_price', $row->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <label class="label-control">Retail Price</label><br>
                                                <input type="text" id="cost_price" name="cost_price" class="form-control" placeholder="Retail Price" value="{{ old('cost_price', $row->regural_price) }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Sale Price -->
                            <div class="modal fade text-left" id="sale_price_modal_{{ $count }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Product Name : {{ $row->name }}</label>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('ajax_update_sale_price', $row->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label-control">Sale Price</label>
                                                            <input type="text" id="sale_price" name="sale_price" class="form-control" placeholder="Retail Price" value="{{ old('sale_price', $row->sale_price) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="label-control">From Date</label>
                                                            <input type="text" id="from_date" name="from_date" class="form-control advertise_datepicker" placeholder="From Date" value="{{ old('from_date', $row->from_date) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="label-control">To Date</label>
                                                            <input type="text" id="to_date" name="to_date" class="form-control advertise_datepicker" placeholder="To Date" value="{{ old('to_date', $row->to_date) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Sale Price -->
                            <div class="modal fade text-left" id="quantity_modal_{{ $count }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Product Name : {{ $row->name }}</label>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('ajax_update_quantity', $row->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <label class="label-control">Quantity</label><br>
                                                <input type="text" id="quantity" name="quantity" class="form-control" placeholder="Retail Price" value="{{ old('quantity', $row->quantity) }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Featured Image -->
                            <input type="hidden" value="{{ env('ADMIN_URL').'public/assets/admin/images/ecommerce/products/'.$row->featured_image }}" id="featured_image_{{ $count }}">
                            <input type="hidden" value="{{ $count++ }}">
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    </div>
@include('layouts.footer')