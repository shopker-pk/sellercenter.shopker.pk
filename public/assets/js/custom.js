$(document).ready(function(){
	//Update Product Status Start
		$(document).on('click', '#status', function(){
			var id = $(this).attr('data-id');
			if($(this).is(':checked') == true){
				$('#'+id).val(0);
			}else{
				$('#'+id).val(1);
			}
		});
	//Update Product Status End
	
	//Add Variations For Products Start
		$(document).on('click', '#add_variations', function(){
			var url = window.location.href.split('add')[0].toString()+'ajax-variations';
			$.ajax({
	            url : url,
	            type : 'GET',
	            success:function(response){
	                json_data = $.parseJSON(response);
	                if(json_data.ERROR == false){
	                	$('#variations').append(json_data.DATA);
	                	$('.select_2').select2();
	                    $('.datepicker').datepicker();
	                }else{
	                    $('#variations').append(json_data.DATA);
	                    $('.select_2').select2();
	                    $('.datepicker').datepicker();
                 	}
	            }
	        });
		});
	//Add Variations For Products End

	//Remove Variations For Products Start
		$(document).on('click', '#remove_variation', function(){
			if(confirm('Are you sure, you want to remove this input?')){
				$(this).closest('div.main').remove();
			}
		});
	//Remove Variations For Products End

	//Getting child categories by parent category id start
		$(document).on('change', '#parent_category', function(){
			var url = document.location.href.split('products')[0].toString()+'products/get-child-categories/'+$(this).val();

			$.ajax({
				url : url,
				type : 'GET',
				success:function(response){
					json_data = $.parseJSON(response);
					if(json_data.ERROR == 'FALSE'){
						$('#child_category').html(json_data.DATA);
					}else if(json_data.ERROR == 'TRUE'){
						$('#child_category').html('<option value="0">No child category found !!</option>');
					}
				}
			});
		});
	//Getting child categories by parent category id end

	//Getting sub child categories by child category id start
		$(document).on('change', '#child_category', function(){
			$.ajax({
				url : document.location.href.split('products')[0].toString()+'products/get-sub-child-categories/'+$(this).val(),
				type : 'GET',
				success:function(response){
					json_data = $.parseJSON(response);
					if(json_data.ERROR == 'FALSE'){
						$('#sub_child_category').html(json_data.DATA);
					}else if(json_data.ERROR == 'TRUE'){
						$('#sub_child_category').html('<option value="0">No sub child category found !!</option>');
					}
				}
			});
		});
	//Getting sub child categories by child category id end
		$(document).on('change', '#child_category', function(){
			
		});
	//Remove Images From Multi Image Input Start
		
	//Remove Images From Multi Image Input End

	//Drag and drop Images Start
		$('#sortable').sortable({
	      	revert: true
	    });

	    $('#draggable').draggable({
	      	connectToSortable: '#sortable',
	      	helper: 'clone',
	      	revert: 'invalid'
	    });

	    $('ul, li').disableSelection();
	//Drag and drop Images End

	//Update Product Cost Price Start
		$(document).on('click', '.cost_price', function(){
			$('#cost_price_modal_'+$(this).attr('data-id')+'').modal({
    			show: true
			});
		});
	//Update Product Cost Price End

	//Update Product Sale Price Start
		$(document).on('click', '.sale_price', function(){
			$('#sale_price_modal_'+$(this).attr('data-id')+'').modal({
    			show: true
			});
		});
	//Update Product Sale Price End

	//Export Orders Start
		$(document).on('click', '.export_orders', function(){
			$('#export_orders').modal({
    			show: true
			});
		});
	//Export Orders End

	//Update Product Quantity Start
		$(document).on('click', '.quantity', function(){
			$('#quantity_modal_'+$(this).attr('data-id')+'').modal({
    			show: true
			});
		});
	//Update Product Quantity End

	//Show Product Image Mouse Over Start
		$(document).on('mouseover', '.featured_image', function(){
			console.log($('#featured_image_'+$(this).attr('data-id')).val());
			$('.show_featured_image').append('<img src="'+$('#featured_image_'+$(this).attr('data-id')).val()+'" style="width: 200px;height: 150px;">');
		});
	//Show Product Image Mouse Over End

	//Hide Product Image Mouse Out Start
		/*$(document).one('mouseout', '.featured_image', function(){
			$('#show_featured_image').empty();
		});*/
	//Hide Product Image Mouse Out End

	//Select 2 Input Start
		$('.select_2').select2();
	//Select 2 Input End

	//wysihtml5 Input Start
		$('.wysihtml5').wysihtml5();
	//wysihtml5 Input End

	//Datepicker Input Start
	 	$(document).on('click', '.datepicker', function(){
			$(this).datepicker({ 
					autoclose: true,
					format: 'dd-MM-yyyy',
				    changeMonth: true,
		   	}).datepicker('show');
		});

		$(document).on('click', '.advertise_datepicker', function(){
			$(this).datepicker({ 
					autoclose: true,
					format: 'yyyy-mm-dd',
				    changeMonth: true,
		    	 	minDate: new Date(),
		    	 	startDate: new Date(),
	    	}).datepicker('show');
		});
	//Datepicker Input End

	//Ajax For Monthly Sales
    $.ajax({
        url : document.location.href.split('dashboard')[0].toString()+'dashboard/monthly-sales',
        method : 'GET',
        success:function(response){
            json_data = $.parseJSON(response);

            if(json_data.ERROR == 'FALSE'){
                monthly_sales.setData(json_data.DATA);
            }
        }
    });

    monthly_sales = Morris.Bar({
        element: 'monthly-sales',
        data: [],
        xkey: 'month',
        ykeys: ['sale'],
        labels: ['Sales'],
        barGap: 4,
        barSizeRatio: 0.3,
        gridTextColor: '#bfbfbf',
        gridLineColor: '#E4E7ED',
        numLines: 5,
        gridtextSize: 14,
        resize: true,
        barColors: ['#00B5B8'],
        hideHover: 'auto',
    });
});