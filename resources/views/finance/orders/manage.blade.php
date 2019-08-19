@include('layouts.header')
	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Orders Overview
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_orders_overview') }}">Manage Orders Overview</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header">
                    	<form action="{{ route('search_orders_overview') }}" method="post">
                    		{{ csrf_field() }}
	                    	<div class="row">
	                            <div class="col-md-3"></div>
	                            <div class="col-md-2">
	                                <input type="text" id="order_no" name="order_no" class="form-control pull-right" placeholder="Order NO#">
	                            </div>
	                            <div class="col-md-2">
	                                <input type="text" id="sku" name="sku" class="form-control pull-right" placeholder="Product SKU">
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
                                    <th>Order Date</th>
                                    <th>Product SKU</th>
                                    <th>Sale Price</th>
                                    <th>Commission</th>
                                    <th>Payout Amount</th>
                                    <th>Operational Status</th>
                                    <th>Payout Status</th>
                                </tr>
                                @if(!empty($query))
                                    @foreach($query as $row)
                                <tr>
                                    <td>{{ $row->order_no }}</td>
                                    <td>{{ date('D-M-Y', strtotime($row->order_date)) }}</td>
                                    <td>{{ $row->sku_code }}</td>
                                    <td>{{ $row->product_amount }}</td>
                                    <td>@if(explode('%', $row->commission_percent)[0] != '') {{ floor((explode('%', $row->commission_percent)[0] / 100) * $row->product_amount) }} @else {{ floor(($row->commission_percent / 100) * $row->product_amount) }} @endif</td>
                                    <td>@if(explode('%', $row->commission_percent)[0] != '') {{ floor(($row->product_amount) - (explode('%', $row->commission_percent)[0] / 100) * $row->product_amount) }} @else {{ floor(($row->product_amount) - ($row->commission_percent / 100) * $row->product_amount) }} @endif</td>
                                    <td>
                                        @if($row->operational_status == 0)
                                            <span class="label label-warning">Pending</span>
                                        @elseif($row->operational_status == 1)
                                            <span class="label label-info">In Process</span>
                                        @elseif($row->operational_status == 2)
                                            <span class="label label-info">Ready To Ship</span>
                                        @elseif($row->operational_status == 3)
                                            <span class="label label-info">Shipped</span>
                                        @elseif($row->operational_status == 4)
                                            <span class="label label-success">Delivered</span>
                                        @elseif($row->operational_status == 5)
                                            <span class="label label-danger">Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->payout_status == 0)
                                            <span class="label label-success">Paid</span>
                                        @else
                                            <span class="label label-danger">Unpaid</span>
                                        @endif
                                    </td>
                                </tr>
                                    @endforeach
                                @else
                                    No Records Found !!
                                @endif
                            </tbody>
                        </table>
                        {{ $query->links() }}
                    </div>
            	</div>
        	</div>
    	</section>
	</div>
@include('layouts.footer')