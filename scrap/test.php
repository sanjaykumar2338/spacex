<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Google Photos</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <style>
     .slider {
    width: 100%;
    height: 300px;
    margin: 100px auto;
    position: relative;
    top: 0;
    left: 0;
    right: 0;
    OVERFLOW: HIDDEN;
    margin-top: 20px;
}
         .img{ text-align: center; line-height: 300px; position: absolute; font-size: 50px; font-family: 'Lobster', cursive; color: #fff; display: none; }
         .img.curry{ display: block; }
         .n{ font-family: 'Lobster', cursive; color: #575757; }
         a{ text-decoration: none; color: #FD7EAD; font-size: 20px; }
         a:hover{ color: #0AB6DD; }
         //.nav{ width: 500px; height: 0px; position: absolute; top: 0px; }
         .navs > button {
    margin: 10px 4px;
}

         input#comment {
    width: 50%;
    display: inline-block;
}

.checkbox {
    width: 40%;
    display: inline-block;
}
      </style>
   </head>
   <body>
      <div class="container">
         <h2>Scrap Google Album Photos</h2>
         <form action="/action_page.php">
            <div class="form-group">
               <label for="email">URL:</label>
               <input type="text" value="https://photos.app.goo.gl/zwjinGi98UNCscue6" class="form-control" id="url" placeholder="Enter URL" name="url">
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
				     <input placeholder="comment..."  class="form-control" name="text" id="comment">
					 <div class="checkbox">
						<label><input id="savetodb" type="checkbox" value="">Done</label>
					</div>
          <div class="navs">
          <button type="button" class="btn btn-default prev n">Prev</button>  
                     <button type="button" class="btn btn-default next n">Next</button> 
                     </div>
                     <div class="slider">
                        <div class="img curry"><img style="width: 77px;margin-left: 233px;" src="https://loading.io/spinners/microsoft/lg.rotating-balls-spinner.gif"></div>
                     </div>
                  </div>
                  <div class="modal-footer">                     
                     <button type="button" class="btn btn-default copy_url">Copy URL</button>                     
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script>
         $('#scrap').on('click',function(e){
         	e.preventDefault();	
         	//$('#sliderModal').modal('show');	
			//return false;
         	if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test($("#url").val())){
         		 $('#sliderModal').modal('show');	
         		
         		 $.post('rock.php',{url:$("#url").val()},function(data){
         			var obj = jQuery.parseJSON(data);
         			$('.slider').html("");

					   if(obj.test.length > 0){
    						jQuery.each(obj.test, function(index, item) {		    						
    							$("<div>",{ html:'<img src="'+item+'=w835-h626-no" />' }).appendTo(".slider"); 
    						});		

                //console.log(obj.guest[0]);	

    						$(".slider").find('div').each(function(i,item) {
             				if(i==0){
                      $(this).attr('data-actual', obj.guest[i]);
             					$(this).addClass('img');
             					$(this).addClass('curry');
             					$(this).find('img').height(400);    						
             				}else{
                      $(this).attr('data-actual', obj.guest[i]);
             					$(this).addClass('img');
             					$(this).find('img').height(400);
             				}
             		});

  					}else{
  						$('.slider').html("No Record Found.");
  					}         			
     		  });
         	} else {
         		alert("invalid URL");
         		return false;
         	}
         	
         	
                
         });
		
		$('#savetodb').change(function() {	
		    if($(this).is(':checked')){
				var comment = $('#comment').val();
				
				if(!comment){
					alert('please write comment');
					$('#savetodb').prop('checked', false);
					
					return false;
				}
				
				var url = $('.curry').attr('data-actual');
				
				$.post('savetodb.php',{url:url,comment:comment}, function(data){
					alert('record saved successfully');
				
				});
			}
		});

		
        $(document).ready(function() {
         
           $('.next').click(function() {
			 $('#comment').val('');  
			 $('#savetodb').prop('checked', false);
			 
             var currentImage = $('.img.curry');
             var currentImageIndex = $('.img.curry').index();
             var nextImageIndex = currentImageIndex + 1;
             var nextImage = $('.img').eq(nextImageIndex);
             currentImage.fadeOut(1000);
             currentImage.removeClass('curry');
             if (nextImageIndex == ($('.img:last').index() + 1)) {
               $('.img').eq(0).fadeIn(1000);
               $('.img').eq(0).addClass('curry');
             } else {
               nextImage.fadeIn(1000);
               nextImage.addClass('curry');
             }
           });
         
           $('.prev').click(function() {
			 $('#comment').val('');  
			 $('#savetodb').prop('checked', false);
			 
             var currentImage = $('.img.curry');
             var currentImageIndex = $('.img.curry').index();
             var prevImageIndex = currentImageIndex - 1;
             var prevImage = $('.img').eq(prevImageIndex);
         
             currentImage.fadeOut(1000);
             currentImage.removeClass('curry');
             prevImage.fadeIn(1000);
             prevImage.addClass('curry');
           });
           
           $('.copy_url').click(function() {
			    var url = $('.curry').find('img').attr('src');
				
         	    //var url = $('.curry').attr('data-actual');

         		var $temp = $("<input>");
         		$("body").append($temp);
         		$temp.val(url).select();
         		document.execCommand("copy");
         		$temp.remove();
           });	
         });
      </script>
   </body>
</html>