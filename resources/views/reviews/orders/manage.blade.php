@include('layouts.header')
	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Order Reviews
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="{{ route('manage_order_reviews') }}">Manage Order Reviews</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header">
                        <form action="{{ route('search_order_reviews') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <input type="text" id="order_no" name="order_no" class="form-control pull-right" placeholder="Order NO#">
                                </div>
                                <div class="col-md-2">
                                    <select id="rating" name="rating" class="form-control select_2">
                                        <option value="0">Ratings Only</option>
                                        <option value="1">With Comments</option>
                                        <option value="2">Both</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select id="reply" name="reply" class="form-control select_2">
                                        <option value="0">Replied</option>
                                        <option value="1">Not Replied</option>
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
                                    <th style="width: 12%;">Order NO#</th>
                                    <th style="width: 39%;">Order Review</th>
                                    <th style="width: 39%;">Reply</th>
                                </tr>
                                @if(!empty($query))
                                    @foreach($query as $row)
                                        <tr>
                                            <td>{{ $row->order_no }}</td>
                                            <td>
                                                <span>
                                                    @if($row->buyer_stars == 1)
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                    @elseif($row->buyer_stars == 2)
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                    @elseif($row->buyer_stars == 3)
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                    @elseif($row->buyer_stars == 4)
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                    @elseif($row->buyer_stars == 5)
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                        <img src="{{ asset('public/assets/images/icons/star1.png') }}" style="width:12px; height:12px">
                                                    @else
                                                        0 Stars
                                                    @endif
                                                </span><br>
                                                <span>{{ $row->first_name }} {{ $row->last_name }} - {{ date('D-M-Y g:i:s A', strtotime($row->buyer_review_created_date.' '.$row->buyer_review_created_time)) }}</span><br>
                                                <span>{{ $row->buyer_comment }}</span>
                                            </td>
                                            <td>
                                                @if($row->vendor_comment != '')
                                                    <span>{{ date('D-M-Y g:i:s A', strtotime($row->vendor_review_created_date.' '.$row->vendor_review_created_time)) }}</span><br>
                                                <span>{{ $row->vendor_comment }}</span>
                                                @else
                                                    <a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#reply_{{ $row->order_no }}">Reply</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    No records found !!
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Edit Order Status Modal -->
                    @if(!empty($query)) 
                        @foreach($query as $row)
                            <div class="modal fade text-left" id="reply_{{ $row->order_no }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Order NO# : {{ $row->order_no }}</label><br>
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Customer Name : {{ $row->first_name }} {{ $row->last_name }}</label>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('reply_order_reviews', $row->order_no) }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <label class="label-control">Comment</label>
                                                <br>
                                                <textarea type="text" name="comment" id="comment" class="form-control" rows="5"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Add
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                    @endif
                </div>
            </div>
		</section>
	</div>
@include('layouts.footer')