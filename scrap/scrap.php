<!DOCTYPE html>
<html lang="en">
<head>
  <title>Google Photos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="main.js"></script>
</head>
<body>

<div class="container">
 <h2>Scrap Google Album Photos</h2>
  <form action="/action_page.php">
    <div class="form-group">
      <label for="email">URL:</label>
      <input type="text" value="" class="form-control" id="url" placeholder="Enter URL" name="url">
    </div>   
    <button type="submit" id="scrap" class="btn btn-default">Submit</button>
  </form>



    <div class="modal fade" id="sliderModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Photos</h4>
        </div>
        <div class="modal-body">
          <div id="slider">
			  <a href="#" class="control_next">></a>
			  <a href="#" class="control_prev"><</a>
			  <ul id="images_list">
				 <img style="width: 77px;margin-left: 233px;" src="https://loading.io/spinners/microsoft/lg.rotating-balls-spinner.gif">
			  </ul>  
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>	
  
</div>
<script>
$('#scrap').on('click',function(e){
	e.preventDefault();	
	$('#sliderModal').modal('show');
	if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test($("#url").val())){
		 $.post('get.php',{url:$("#url").val()},function(data){
			var obj = jQuery.parseJSON(data);
			$('#images_list').html("");
			jQuery.each(obj.test, function(index, item) {				
				$("<li>",{ html:'<img src="'+item+'" />' }).appendTo("#images_list"); 
				
				
				//var img = $('<img>'); 
				//img.attr('src', item);
				//img.appendTo('.modal-body');
			});
		 });
	} else {
		alert("invalid URL");
		return false;
	}
	
	
       
});	
</script>

</body>
</html>
