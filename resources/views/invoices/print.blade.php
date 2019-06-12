@include('layouts.header')
	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Invoice Details
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('manage_invoices') }}"><i class="fa fa-square"></i> Manage Invoices</a></li>
                <li class="active"><a href="{{ route('invoice_details', 00001) }}">Invoice Details</a></li>
            </ol>
        </section>
        <style type="text/css">
            #basic-form-layouts{
                box-shadow: 30px;
            }
        </style>
        <section id="basic-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-content collpase show" style="border: 1px solid #989797;">
                            <div class="panel-body">
                                <form class="form form-horizontal form-bordered">
                                    <div class="row form-section">
                                        <div class="col-md-4">
                                            <div class="form-body">
                                                <h4>Invoice Details</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-2">
                                            <div class="form-body">
                                                <a id="print" href="javascript::void(0);">Print Invoice</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="print_section">
                                        <div class="css_js" style="display: hidden">
                                        </div>
                                        <div id="invoice-company-details" class="row">
                                            <div class="col-md-6 col-sm-12 text-left ml-2 text-md-left">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h2>Company Details</h2>
                                                        <ul class="list-unstyled">
                                                            <li class="text-bold-800">{{ $header_details->title }}</li>
                                                            <li>{{ $header_details->address }}</li>
                                                            <li>{{ $header_details->zip_code }}</li>
                                                            <li>{{ $header_details->city_name }}</li>
                                                            <li>{{ $header_details->country_name }}</li>
                                                        </ul>
                                                        <h2>Customer Details</h2>
                                                        <ul class="list-unstyled">
                                                            <li class="text-bold-800">
                                                                <label>Name :</label>{{ $invoice_and_customer_details->first_name.' '.$invoice_and_customer_details->last_name }}                                                   
                                                            </li>
                                                            <li class="text-bold-800">
                                                                <label>Contact :</label>{{ $invoice_and_customer_details->phone_no }}                               
                                                            </li>
                                                            <li class="text-bold-800">
                                                                <label>Email :</label>{{ $invoice_and_customer_details->email }}                                    
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 text-right text-md-right">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h2>Invoice Details</h2>
                                                        <ul class="ml-2 px-0 list-unstyled">
                                                            <li class="text-bold-800">
                                                                <label>No# :</label>{{ $invoice_and_customer_details->order_no }}                                               
                                                            </li>
                                                            <li class="text-bold-800">
                                                                <label>Date :</label>{{ date('d-m-Y', strtotime($invoice_and_customer_details->order_date)) }}                                  
                                                            </li>
                                                            <li class="text-bold-800">
                                                                <label>Transaction ID :</label>{{ $invoice_and_customer_details->transaction_id }}                      
                                                            </li>
                                                            <li class="text-bold-800">
                                                                <label>Total Amount :</label>{{ $invoice_and_customer_details->total }}
                                                            </li>
                                                            <li class="text-bold-800">
                                                                <label>Order Status :</label>@if($invoice_and_customer_details->order_status == 0)
                                                                    <span class="badge badge-success">Delivered</span>
                                                                @elseif($invoice_and_customer_details->order_status == 1)
                                                                    <span class="badge badge-primary">Active</span>
                                                                @elseif($invoice_and_customer_details->order_status == 2)
                                                                    <span class="badge badge-warning">In Process</span>
                                                                @else
                                                                    <span class="badge badge-danger">Rejected</span>
                                                                @endif
                                                            </li>
                                                            <li class="text-bold-800">
                                                                <label>Payment Status :</label>@if($invoice_and_customer_details->payment_status == 0)
                                                                    <span class="badge badge-default badge-success">Paid</span>
                                                                @else
                                                                    <span class="badge badge-default badge-danger">Unpaid</span>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br><br>
                                        <div class="table-responsive">          
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Product Type</th>
                                                        <th>Product Quantity</th>
                                                        <th>Product Amount</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order_details as $row)
                                                    <tr>
                                                        <td>{{ $row->product_name }}</td>
                                                        <td>@if($row->type == 0) On Sale @elseif($row->type == 1) Normal @endif</td>
                                                        <td>{{ $row->product_quantity }}</td>
                                                        <td>{{ $row->product_price }}</td>
                                                        <td>{{ $row->total_amount }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7 col-sm-12"></div>
                                            <div class="col-md-5 col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>Sub Total</td>
                                                                <td class="text-right">{{ $subtotal }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Discount</td>
                                                                <td class="text-right">{{ $discount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shipping</td>
                                                                <td class="text-right"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold-800">Total</td>
                                                                <td class="text-bold-800 text-right">{{ $total }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>
@include('layouts.footer')