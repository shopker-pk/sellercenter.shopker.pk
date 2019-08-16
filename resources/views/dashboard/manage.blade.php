@include('layouts.header')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="row">
                <a href="{{ route('manage_products') }}">
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                @if(!empty($total_products->total_products)) 
                                <h3>{{ $total_products->total_products }}</h3>
                                @else
                                <h3>0</h3>
                                @endif
                                <p>Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('manage_orders') }}">
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                                @if(!empty($total_users->total_users)) 
                                <h3>{{ $total_users->total_users }}</h3>
                                @else
                                <h3>0</h3>
                                @endif
                                <p>Customers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('manage_orders') }}">
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">
                                @if(!empty($total_new_orders->new_orders)) 
                                <h3>{{ $total_new_orders->new_orders }}</h3>
                                @else
                                <h3>0</h3>
                                @endif
                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('manage_account_statement') }}">
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                @if(!empty($total_earning->total_earning)) 
                                <h3>{{ $total_earning->total_earning }}</h3>
                                @else
                                <h3>0</h3>
                                @endif
                                <p>Total Earning</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-body sales-growth-chart">
                                <div id="monthly-sales" class="height-250"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="panel-body">
                            <div class="chart-title mb-1 text-center">
                                <h4>Monthly Revenues</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('layouts.footer')