@include('layouts.header')
	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Product Reviews
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-square"></i> Dashboard</a></li>
                <li class="active"><a href="manage_product_reviews.php">Manage Product Reviews</a></li>
            </ol>
        </section>
        <section class="content">
            @include('layouts.messages')
            <div class="box box-default">
                <div class="box-body">
                    <div class="box-header">
                        <form action="{{ route('search_product_reviews') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <input type="text" id="name" name="name" class="form-control pull-right" placeholder="Product Name">
                                </div>
                                <div class="col-md-2">
                                    <select id="rating" name="rating" class="form-control select_2">
                                        <option value="0">Ratings Only</option>
                                        <option value="1">Comment Only</option>
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
                                    <th style="width: 30%;">Product Name</th>
                                    <th style="width: 35%;">Product Review</th>
                                    <th style="width: 35%;">Reply</th>
                                </tr>
                                @if(!empty($query))
                                    @foreach($query as $row)
                                        <tr>
                                            <td>{{ $row->product_name }}</td>
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
                                                    {{ $row->vendor_comment }}
                                                @else
                                                    <a href="javascript::void(0);" class="dropdown-item" data-toggle="modal" data-target="#reply_{{ $row->p_id }}">Reply</a>
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
                            <div class="modal fade text-left" id="reply_{{ $row->p_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Product Name : {{ $row->product_name }}</label><br>
                                            <label class="modal-title text-text-bold-600" id="myModalLabel33">Customer Name : {{ $row->first_name }} {{ $row->last_name }}</label>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('reply_product_reviews', $row->id) }}" method="post">
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