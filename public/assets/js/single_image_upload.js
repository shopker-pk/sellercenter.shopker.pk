$(document).ready(function(){
	//Single Image Preview Start
		$(document).on('change', '#single_image', function(e){
			e.preventDefault();
			if(window.File && window.FileList && window.FileReader){
	            var files = e.target.files,
	            filesLength = files.length;
	            var id = $(this).attr('data-id');
	            for(var i = 0; i < filesLength; i++){
	                var f = files[i]
	                var fileReader = new FileReader();
	                fileReader.onload = (function(e){
	                    var file = e.target;
	                    $('.single_image_preview_'+id+'').attr('src', e.target.result);
	                });
	                fileReader.readAsDataURL(f);
	            }
        	}
		});
	//Single Image Preview End
});