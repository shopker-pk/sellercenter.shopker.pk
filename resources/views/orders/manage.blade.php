@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Orders
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_orders') }}">Manage Orders</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header">
                        <form action="{{ route('search_orders') }}" method="get">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" id="order_no" name="order_no" class="form-control pull-right" placeholder="Order NO#">
                                </div>
                                <div class="col-md-2">
                                    <select id="payment_method" name="payment_method" class="form-control select_2">
                                        <option value="0">Jazz Cash</option>
                                        <option value="1">Easy Paisa</option>
                                        <option value="2">Cash on delivery</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="status" name="status" class="form-control select_2">
                                        <option value="0">Pending</option>
                                        <option value="1">In Process</option>
                                        <option value="2">Ready to Ship</option>
                                        <option value="3">Shiped</option>
                                        <option value="4">Delivered</option>
                                        <option value="5">Canceled</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control datepicker" id="from" name="from" placeholder="From Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control datepicker" id="to" name="to" placeholder="To Date">
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-default export_orders" href="javascript::void(0);">Export</a>
                                </div>
                            </div>        
                        </form>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Order NO#</th>
                                    <th>Payment Type</th>
                                    <th>Order Amount</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                                 @if(!empty($query))
                                        @foreach($query as $row)
                                        <tr>
                                            <td><a href="{{ route('invoice_details', $row->order_no) }}" target="__parent">Invoice</a></td>
                                            <td>{{ $row->order_no }}</td>
                                            <td>
                                                @if($row->payment_method == 0)
                                                    Jazz Cash
                                                @elseif($row->payment_method == 1)
                                                    Easy Paisa
                                                @else
                                                    Cash On Delivery
                                                @endif
                                            </td>
                                            <td>{{ $row->total }}</td>
                                            <td>
                                                @if($row->p_status == 0)
                                                    <span class="label label-success">Paid</span>
                                                @else
                                                    <span class="label label-danger">Unpaid</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->o_status == 0)
                                                    <span class="label label-warning">Pending</span>
                                                @elseif($row->o_status == 1)
                                                    <span class="label label-info">In Process</span>
                                                @elseif($row->o_status == 2)
                                                    <span class="label label-info">Ready To Ship</span>
                                                @elseif($row->o_status == 3)
                                                    <span class="label label-info">Shipped</span>
                                                @elseif($row->o_status == 4)
                                                    <span class="label label-success">Delivered</span>
                                                @elseif($row->o_status == 5)
                                                    <span class="label label-danger">Canceled</span>
                                                @endif
                                            </td>
                                            <td>{{ date('D-M-Y', strtotime($row->order_date)) }}</td>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
                                                    <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#order_{{ $row->order_no }}">Edit Order Status</a></li>
                                                        <li><a href="{{ route('order_details',  $row->order_no) }}">View Order Details</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    No records found !!
                                @endif
                            </tbody>
                        </table>
                        <!-- Edit Order Status Modal -->
                        @if(!empty($query)) 
                            @foreach($query as $row)
                                <div class="modal fade text-left" id="order_{{ $row->order_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <label class="modal-title text-text-bold-600" id="myModalLabel33">Order NO# : {{ $row->order_no }}</label>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('update_order_status', $row->order_no) }}" method="post">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <label class="label-control">Order Status</label>
                                                    <br>
                                                    <select id="order_status" name="order_status" class="form-control select_2" style="width: 100%">
                                                        <option value="1" @if($row->o_status == 1) selected @endif>In Process</option>
                                                        <option value="2" @if($row->o_status == 2) selected @endif>Ready to Ship</option>
                                                        <option value="5" @if($row->o_status == 5) selected @endif>Canceled</option>
                                                    </select>
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
                            @endforeach 
                        @endif

                        <!-- Export Variations -->
                        <div class="modal fade text-left" id="export_orders" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <label class="modal-title text-text-bold-600" id="myModalLabel33">Export Orders</label>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('export_orders') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="label-control">Select Orders Type</label><br>
                                                    <select id="order_type" name="order_type" class="form-control select_2" style="width: 100%">
                                                        <option value="0">Pending</option>
                                                        <option value="1">In Process</option>
                                                        <option value="2">Ready to Ship</option>
                                                        <option value="3">Shiped</option>
                                                        <option value="4">Delivered</option>
                                                        <option value="5">Canceled</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="label-control">Write File Name</label><br>
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Write File Name*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-check-square-o"></i> Export
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('layouts.footer')