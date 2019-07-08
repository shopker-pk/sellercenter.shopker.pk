<?php
	//Vendor Panel Routes Start
		//Auth Routes Start
			Route::get('/', 'Auth\AuthController@sign_in')->name('vendor_sign_in');
			Route::post('/vendor/validating-credentials', 'Auth\AuthController@validating_credentials')->name('vendor_validating_credentials');
			Route::get('/vendor/sign-out', 'Auth\AuthController@sign_out')->name('vendor_sign_out');
		//Auth Routes End

		//Dashboard Routes Start
			Route::get('/vendor/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
		//Dashboard Routes End

		//Ecommerce Routes Start
			//Products Routes Start
				Route::get('/vendor/ecommerce/products/manage', 'Ecommerce\ProductsController@index')->name('manage_products');
				Route::get('/vendor/ecommerce/products/get-child-categories/{id}', 'Ecommerce\ProductsController@get_child_categories');
				Route::get('/vendor/ecommerce/products/get-sub-child-categories/{id}', 'Ecommerce\ProductsController@get_sub_child_categories');
				Route::get('/vendor/ecommerce/products/ajax-variations', 'Ecommerce\ProductsController@ajax_variations');
				Route::get('/vendor/ecommerce/products/add', 'Ecommerce\ProductsController@add')->name('add_product');
				Route::post('/vendor/ecommerce/products/insert', 'Ecommerce\ProductsController@insert')->name('insert_product');
				Route::get('/vendor/ecommerce/products/ajax/update-status/{id}/{status}', 'Ecommerce\ProductsController@ajax_update_status')->name('ajax_update_product_status');
				Route::post('/vendor/ecommerce/products/ajax/update-cost-price/{id}', 'Ecommerce\ProductsController@ajax_update_cost_price')->name('ajax_update_cost_price');
				Route::post('/vendor/ecommerce/products/ajax/update-sale-price/{id}', 'Ecommerce\ProductsController@ajax_update_sale_price')->name('ajax_update_sale_price');
				Route::post('/vendor/ecommerce/products/ajax/update-quantity/{id}', 'Ecommerce\ProductsController@ajax_update_quantity')->name('ajax_update_quantity');
				Route::get('/vendor/ecommerce/products/edit/{id}', 'Ecommerce\ProductsController@edit')->name('edit_product');
				Route::post('/vendor/ecommerce/products/update/{id}', 'Ecommerce\ProductsController@update')->name('update_product');
				Route::get('/vendor/ecommerce/products/duplicate/{id}', 'Ecommerce\ProductsController@duplicate')->name('add_duplicate_product');
				Route::post('/vendor/ecommerce/products/duplicate-insert/{id}', 'Ecommerce\ProductsController@duplicate_insert')->name('insert_duplicate_product');
				Route::get('/vendor/ecommerce/products/delete/{id}', 'Ecommerce\ProductsController@delete')->name('delete_product');
				Route::post('/vendor/ecommerce/products/search', 'Ecommerce\ProductsController@search')->name('search_products');
			//Products Routes End
		//Ecommerce Routes End

		//Order Routes Start
			Route::get('/vendor/orders/manage', 'Orders\OrdersController@manage')->name('manage_orders');
			Route::post('/vendor/orders/export', 'Orders\OrdersController@export')->name('export_orders');
			Route::post('/vendor/orders/update/order-status/{order_no}', 'Orders\OrdersController@update_order_status')->name('update_order_status');
			Route::post('/vendor/orders/update/payment-status/{order_no}', 'Orders\OrdersController@update_payment_status')->name('update_payment_status');
			Route::get('/vendor/orders/details/{order_no}', 'Orders\OrdersController@details')->name('order_details');
			Route::get('/vendor/orders/search', 'Orders\OrdersController@search')->name('search_orders');
		//Order Routes End

		//Invoice Routes Start
			Route::get('/vendor/invoices/manage', 'Invoices\InvoicesController@manage')->name('manage_invoices');
			Route::get('/vendor/invoices/details/{id}', 'Invoices\InvoicesController@details')->name('invoice_details');
			Route::get('/vendor/invoices/print/{id}', 'Invoices\InvoicesController@print')->name('print_invoice');
			Route::post('/vendor/invoices/search', 'Invoices\InvoicesController@search')->name('search_invoices');
		//Invoice Routes End

		//Reviews Routes Start
			//Product Routes Start
				Route::get('/vendor/reviews/products/manage', 'Reviews\ProductsController@manage')->name('manage_product_reviews');
				Route::post('/vendor/reviews/products/reply/{id}', 'Reviews\ProductsController@reply')->name('reply_product_reviews');
				Route::post('/vendor/reviews/products/search', 'Reviews\ProductsController@search')->name('search_product_reviews');
			//Product Routes End

			//Orders Routes Start
				Route::get('/vendor/reviews/orders/manage', 'Reviews\OrdersController@manage')->name('manage_order_reviews');
				Route::post('/vendor/reviews/orders/reply/{order_no}', 'Reviews\OrdersController@reply')->name('reply_order_reviews');
				Route::post('/vendor/reviews/orders/search', 'Reviews\OrdersController@search')->name('search_order_reviews');
			//Orders Routes End
		//Reviews Routes End

		//Finance Routes Start
			//Order Routes Start
				Route::get('/vendor/finance/orders-overview/manage', 'Finance\OrdersController@manage')->name('manage_orders_overview');
				Route::post('/vendor/finance/orders-overview/search', 'Finance\OrdersController@search')->name('search_orders_overview');
			//Order Routes End

			//Account Statement Routes Start
				Route::get('/vendor/finance/account-statement/manage', 'Finance\AccountsController@manage')->name('manage_account_statement');
				Route::post('/vendor/finance/account-statement/search', 'Finance\AccountsController@search')->name('search_account_statement');
			//Account Statement Routes End
		//Finance Routes End

		//Settings Routes Start
			//Profile Routes Start
				Route::get('/vendor/settings/profile/manage', 'Settings\ProfileController@manage')->name('manage_profile_settings');
				Route::post('/vendor/settings/profile/update', 'Settings\ProfileController@update')->name('update_profile_settings');
			//Profile Routes End

			//Store Routes Start
				Route::get('/vendor/settings/store/manage', 'Settings\StoreController@manage')->name('manage_store_settings');
				Route::post('/vendor/settings/store/update', 'Settings\StoreController@update')->name('update_store_settings');
			//Store Routes End
		//Settings Routes End
	//Vendor Panel Routes End