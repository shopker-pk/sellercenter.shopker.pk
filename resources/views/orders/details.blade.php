@include('layouts.header')
	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Order Details
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('manage_orders') }}"><i class="fa fa-square"></i> Manage Orders</a></li>
                <li class="active"><a href="{{ route('order_details', $order_summary->order_no) }}">Order Details</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width:15%; font-weight:600;">Product Image</th>
                                    <th style="width:25%; font-weight:600;">Product Name</th>
                                    <th style="width:10%; font-weight:600;">Product Retail Price</th>
                                    <th style="width:10%; font-weight:600;">Product Sale Price</th>
                                    <th style="width:40%; font-weight:600;">Additional Info</th>
                                </tr>
                                @foreach($cart_details as $row)
                                    <tr>
                                    	<td>
                                        	<img src="{{ env('ADMIN_URL').'public/assets/admin/images/ecommerce/products/'.$row->featured_image }}" alt="Featured Image" style="width: 130px; height: 105px;">
                                        </td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->regural_price }}</td>
                                        <td>{{ $row->product_amount }}</td>
                                        <td>
                                            <span>SKU Code : {{ $row->sku_code }}</span><br>
                                            <span>Product Quantity : {{ $row->quantity }}</span><br>
                                            <span>Product Type : @if($row->type == 0) Sale @else Normal @endif </span><br>
                                            <span>Product Brand : {{ $row->b_name }} </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                	<div class="box box-default" style="border-top: 3px solid white;">
                    	<div class="box-body" style="height:250px;">
                    		<h4>Customer Details</h4>
                    		<hr style="border-top:1px solid black">
                    		<span>Full Name : {{ $customer_details->first_name.' '.$customer_details->last_name }}</span><br>
                    		<span>Contact No# : {{ $customer_details->phone_no }}</span><br>
                    		<span>Email : {{ $customer_details->email }}</span><br>
                    		<span>Address : {{ $customer_details->address }}</span><br>
                            <span>City : {{ $customer_details->city_name }}</span><br>
                            <span>Country : {{ $customer_details->country_name }}</span><br><br>
                		</div>
            		</div>
            	</div>
            	<div class="col-md-4">
                	<div class="box box-default" style="border-top: 3px solid white;">
                    	<div class="box-body" style="height:250px;">
                    		<h4>Shipping Details</h4>
                    		<hr style="border-top:1px solid black">
                    		<span>Full Name : {{ $shipping_details->first_name.' '.$shipping_details->last_name }}</span><br>
                    		<span>Contact No# : {{ $shipping_details->phone_no }}</span><br>
                    		<span>Address : {{ $shipping_details->address }}</span><br>
                            <span>City : {{ $shipping_details->city_name }}</span><br>
                            <span>Country : {{ $shipping_details->country_name }}</span><br>
                            <span>Area : @foreach($areas as $row) @if($row['area_id'] == $shipping_details->area_id) {{ $row['area_name'] }} @endif @endforeach</span>
                		</div>
            		</div>
            	</div>
            	<div class="col-md-4">
                	<div class="box box-default" style="border-top: 3px solid white;">
                    	<div class="box-body" style="height:250px">
                    		<h4>Order Summary</h4>
                    		<hr style="border-top:1px solid black">
                    		<span>Order No# : {{ $order_summary->order_no }}</span><br>
                    		<span>Subtotal : {{ $order_summary->sub_total }}</span><br>
                    		<span>Discount : </span><br>
                    		<span>Shipping Fee : {{ $order_summary->charges }}</span><br>
                    		<span>Total : {{ $order_summary->total }}</span><br>
                    	</div>
            		</div>
            	</div>
        	</div>
        </section>
    </div>
@include('layouts.footer')