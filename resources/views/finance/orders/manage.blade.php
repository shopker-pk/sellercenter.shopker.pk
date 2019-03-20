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
                                    <th>Unit Price</th>
                                    <th>Sale Price</th>
                                    <th>Commission</th>
                                    <th>VAT</th>
                                    <th>Payout Amount</th>
                                    <th>Operational Status</th>
                                    <th>Payout Status</th>
                                </tr>
                                <tr>
                                    <td>00001</td>
                                    <td>16-10-2018</td>
                                    <td>Product 1 Product SKU 1</td>
                                    <td>1599</td>
                                    <td>1499</td>
                                    <td>-49</td>
                                    <td>-50</td>
                                    <td>1400</td>
                                    <td><span class="label label-success">Delivered</span></td>
                                    <td><span class="label label-warning">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            	</div>
        	</div>
    	</section>
	</div>
@include('layouts.footer')