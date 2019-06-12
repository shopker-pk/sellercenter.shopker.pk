@include('layouts.header')
	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Account Statement
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_account_statement') }}">Manage Account Statement</a></li>
            </ol>
        </section>
        <section class="content">
        	<div class="container-fluid panel" style="border-top:2px solid #ccc; padding-top: 20px; padding-bottom: 100px;"> 
                <div class="row">
                    <form action="{{ route('search_account_statement') }}" method="post">
                        {{ csrf_field() }}
                        <div class="col-md-7"></div>
            			<div class="col-md-2">
            				<input type="text" id="from" name="from" class="form-control datepicker" placeholder="From">
            			</div>
            			<div class="col-md-2">
            				<input type="text" id="to" name="to" class="form-control datepicker" placeholder="To">
            			</div>
                        <div class="col-md-1">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
            			<!-- <div class="col-md-1">
            				<button class="btn btn-default" style="width: 100%;">Print</button>
            			</div>
            			<div class="col-md-1">
            				<button class="btn btn-default" style="width: 100%;">Export</button>
            			</div> -->
            		</div>
                </form>
        		<hr/>
        		<div class="container">
        			<div class="row">
        				<div class="col-md-1"></div>
        				<div class="col-md-10">
        					<div class="panel-body" style="border: 1px solid #ccc; margin-top: 50px; overflow: hidden; box-shadow: 1px 3px 10px 4px #E1E1DD;">
        						<div class="row" style="margin-top: 40px;">
        							<div class="col-md-1"></div>
        							<div class="col-md-2">
        								<h4><b>Order Payment</b></h4>
        							</div>
        							<div class="col-md-8">

        								<div class="row">
        									<div class="col-md-3">
        										<div class="paymentitems">
	        									 	<span class="itemsofpayment">Item Charges</span><br/>
		        								</div>
        									</div>
        									<div class="col-md-6"></div>
        									<div class="col-md-3" id="contenright">
        										<span class="price1">{{ $query['total_earning'] }} PKR</span><br/>
		        							</div>
        								</div>
        								<div class="row">
        									<div class="col-md-3">
        										<div class="paymentitems">
        									 		<span class="itemsofpayment">Shopker Fees</span><br/>
		        								</div>
        									</div>
        									<div class="col-md-6"></div>
        									<div class="col-md-3" id="contenright">
        										<div class="paymentitems">
        									 		<span class="price1">- {{ $query['total_commission'] }} PKR</span><br/>
		        								</div>
        									</div>
        								</div>
        								<hr style="border: 1px solid #888888"/>
        								<div class="row">
        									<div class="col-md-3">
        										<span class="price1">Subtotal</span>	
        									</div>
        									<div class="col-md-2"></div>
        									<div class="col-md-7" id="contenright">
        										<span class="price1">{{ $query['sub_total'] }} PKR</span>	
        									</div>
        								</div>
        							</div>
        						</div>
        						<hr style="border: 1px solid #888888"/>
        						<div class="row">
        							<div class="col-md-1"></div>
        							<div class="col-md-2">
        								<h4 style="margin-top:0px;"><b>Closing Balance</b></h4>
        							</div>
        							<div class="col-md-2">
        								<span class="price1">Total Balance</span>
        							</div>
        							<div class="col-md-2"></div>
        							<div class="col-md-4" id="contenright">
        								<span class="price1">{{ $query['sub_total'] }} PKR</span>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
		</section>
	</div>	
@include('layouts.footer')