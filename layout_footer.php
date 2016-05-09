    </div>
    <!-- /container -->
     
<!-- jQuery library -->
<script src="libs/js/jquery.js"></script>

<!-- bootstrap JavaScript -->
<script src="libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="libs/js/bootstrap/docs-assets/js/holder.js"></script>
 
<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- jquery ui -->
<script src="libs/js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

<script>
$(document).ready(function(){
	// jquery ui date picker
	$( "#date-from" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#date-to" ).datepicker({ dateFormat: 'yy-mm-dd' });
	
	//check/uncheck script
	$(document).on('click', '#checker', function(){
		$('.checkboxes').prop('checked', $(this).is(':checked'));
	});
		
	
	// delete selected records	
	$(document).on('click', '#delete-selected', function(){

		var at_least_one_was_checked = $('.checkboxes:checked').length > 0;
			
		if(at_least_one_was_checked){
		
			var answer = confirm('Are you sure?');
			
			if (answer){
					
					// get converts it to an array
					var del_checkboxes = $('.checkboxes:checked').map(function(i,n) {
						return $(n).val();
					}).get();

					if(del_checkboxes.length==0) {
						del_checkboxes = "none"; 
					}  
					
					$.post("delete_selected.php", {'del_checkboxes[]': del_checkboxes}, 
						function(response) {
						
							if(response==""){
								// refresh
								location.reload();
							}else{
								// tell the user there's a problem
								alert(response);
							}
						
					});

			}
		}
		
		else{
			alert('Please select at least one record to delete.');
		}
	});
		
	// delete record
	$(document).on('click', '.delete-object', function(){
	 
		// php file used for deletion
		var delete_file = $(this).attr('delete-file');
		
		var id = $(this).attr('delete-id');
		var q = confirm("Are you sure?");
	 
		if (q == true){
	 
			$.post(delete_file, {
				object_id: id
			}, function(data){
				location.reload();
			}).fail(function() {
				alert('Unable to delete.');
			});
	 
		}
		return false;
	});
});
</script>

</body>
</html>