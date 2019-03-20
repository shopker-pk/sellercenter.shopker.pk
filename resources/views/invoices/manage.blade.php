@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Invoices
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_invoices') }}">Manage Invoices</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header">
                        <form action="{{ route('search_invoices') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" id="order_no" name="order_no" class="form-control pull-right" placeholder="Order NO#">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="transaction_id" name="transaction_id" class="form-control pull-right" placeholder="Transaction ID">
                                </div>
                                <div class="col-md-2">
                                    <select id="payment_type" name="payment_type" class="form-control select_2">
                                        <option value="0">Jazz Cash</option>
                                        <option value="1">Easy Paisa</option>
                                        <option value="2">Cash on delivery</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="order_status" name="order_status" class="form-control select_2">
                                        <option value="0">Pending</option>
                                        <option value="1">In Process</option>
                                        <option value="2">Ready to Ship</option>
                                        <option value="3">Shiped</option>
                                        <option value="4">Delivered</option>
                                        <option value="5">Canceled</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="payment_status" name="payment_status" class="form-control select_2">
                                        <option value="0">Paid</option>
                                        <option value="1">Un Paid</option>
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
                            </div>
                        </form> 
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Order NO#</th>
                                    <th>Transaction ID</th>
                                    <th>Order Amount</th>
                                    <th>Order Date</th>
                                    <th>Payment Type</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                                @if(!empty($query))
                                    @foreach($query as $row)
                                        <tr>
                                            <td>{{ $row->order_no }}</td>
                                            <td>{{ $row->transaction_id }}</td>
                                            <td>{{ $row->total }}</td>
                                            <td>{{ date('D-M-Y', strtotime($row->order_date)) }}</td>
                                            <td>
                                                @if($row->payment_method == 0)
                                                    Jazz Cash
                                                @elseif($row->payment_method == 1)
                                                    Easy Paisa
                                                @else
                                                    Cash On Delivery
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
                                            <td>
                                                @if($row->p_status == 0)
                                                    <span class="label label-success">Paid</span>
                                                @else
                                                    <span class="label label-danger">Unpaid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
                                                    <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{ route('invoice_details', $row->order_no) }}">View Details</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('layouts.footer')