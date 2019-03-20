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
        <section class="content">
            @include('layouts.messages')
		</section>
	</div>
@include('layouts.footer')