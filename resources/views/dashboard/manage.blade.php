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
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            @if(!empty($new_orders))
                                <h3>{{ $new_orders->total_orders }}</h3>
                                @if($new_orders->total_orders == 1)
                                    <p>New Order</p>
                                @else
                                    <p>New Orders</p>
                                @endif
                            @else
                                <h3>0</h3>
                                <p>New Orders</p>
                            @endif
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('manage_orders') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            @if(!empty($delivered_orders))
                                <h3>{{ $delivered_orders->total_orders }}</h3>
                                @if($delivered_orders->total_orders == 1)
                                    <p>Delivered Order</p>
                                @else
                                    <p>Delivered Orders</p>
                                @endif
                            @else
                                <h3>0</h3>
                                <p>Delivered Orders</p>
                            @endif
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('manage_orders') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            @if(!empty($canceled_orders))
                                <h3>{{ $canceled_orders->total_orders }}</h3>
                                @if($canceled_orders->total_orders == 1)
                                    <p>Canceled Order</p>
                                @else
                                    <p>Canceled Orders</p>
                                @endif
                            @else
                                <h3>0</h3>
                                <p>Canceled Orders</p>
                            @endif
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('manage_orders') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>44</h3>
                            <p>Total Sales</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="javascipt::void(0)" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                            <li class="pull-left header"><i class="fa fa-inbox"></i> Revenue</li>
                        </ul>
                        <div class="tab-content no-padding">
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 373px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-solid bg-teal-gradient">
                        <div class="box-header">
                            <i class="fa fa-th"></i>
                            <h3 class="box-title">Orders</h3>
                        </div>
                        <div class="box-body border-radius-none">
                            <div class="chart" id="orders-chart" style="height: 250px;"></div>
                        </div>
                        <div class="box-footer no-border">
                            <div class="row">
                                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">
                                    <div class="knob-label">New Orders</div>
                                </div>
                                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">
                                    <div class="knob-label">Delivered Orders</div>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">
                                    <div class="knob-label">Canceled Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('layouts.footer')