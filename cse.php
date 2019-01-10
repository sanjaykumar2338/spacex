<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Google Photos
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
    </script>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./tipped.css">
    <style>
      .gsc-table-cell-thumbnail.hover .gs-image-box.gs-web-image-box.gs-web-image-box-portrait{
        overflow: visible;
      }
      .gs-image:hover {
        -ms-transform: scale(4.5);
        -webkit-transform: scale(4.5);
        transform: scale(4.5);   
        margin-left: 40px;      
      }

      span {
        cursor: pointer;
      }
      .slider {
        width: 100%;
        margin: 100px auto;
        position: relative;
        top: 0;
        left: 0;
        right: 0;
        OVERFLOW: visible;
        margin-top: 20px;
      }
      .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
      }
      .wrapper{
        text-align: center;
      }
      h1{
        margin-bottom: 1.25em;
      }
      #pagination-demo{
        display: inline-block;
        margin-bottom: 1.75em;
      }
      #pagination-demo li{
        display: inline-block;
      }
      .gsc-tabsArea .gsc-tabHeader{
        height: 30px;
      }
      .page-content{
        background: #eee;
        display: inline-block;
        padding: 10px;
        max-width: 660px;
      }
      input#url {
        width: 50%;
        display: inline-block;
      }      
    </style>
  </head>
  <body>
    <div class="container">
      <form action="/action_page.php">
        <button type="submit" id="open_search" class="btn btn-default">open search
        </button>
      </form>
      <div class="modal fade" id="sliderModal" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <span style="float: left;"><input type="text" style="width: 400px;" id="url_search"> <span id="get_url_search" style="color: blue;">Get Details from URL</span></span> <button type="button" class="close" data-dismiss="modal">&times;
              </button>                    
            </div>
            <div class="modal-body">
              <!-- Replace the following with your own search script from https://www.google.com/cse. -->
              <script>
                (function() {
                  var cx = '006084619413404036248:dl1t-ht6bbw';
                  var gcse = document.createElement('script');
                  gcse.type = 'text/javascript';
                  gcse.async = true;
                  gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                  var s = document.getElementsByTagName('script')[0];
                  s.parentNode.insertBefore(gcse, s);
                }
                )();
              </script>
              <gcse:search>
              </gcse:search>
            </div>
            <div class="modal-footer">
              <div class="wrapper">
                <div class="container">
                  <div class="row">
                    <div class="col-sm-9">
                      <ul id="pagination-demo" class="pagination-sm">
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="secondModal" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;
              </button>
              <h4 class="modal-title">Output
              </h4>
            </div>
            <div class="modal-body">
              <div id="outpout">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      /*** SEARCH FUNCTION TO SEARCH DATA OF URL ***/  
      function search(){
        //e.preventDefault();                        
        if(!$("#url").val()){
          alert('enter a term to search');
          return false;
        }
        if($('.pagination').data("twbs-pagination")){
          $('.pagination').twbsPagination('destroy');
        }
        $('#google_result').html('');
        $('.slider').show();

      }

      $('#sliderModal').on('hidden.bs.modal', function () {
        window.location.href = 'http://localhost/spacex/cse.php';
      });
      
      /*** OPEN A MODAL LANDING PAGE ***/                   
      $(document).on("click", "#open_search", function(e){
        e.preventDefault();
        $('.slider').hide();
        $('#sliderModal').modal('show');
      });

      /*** FOR GET A DETAILS IN MODAL OF EBAY AMAZON ***/
      $(document).on("click", ".get_url", function(e){
        e.preventDefault();
        $(document).find('.previousclick').css("color","black");
        var _that = $(this);
        _that.addClass('previousclick');
        _that.css("color","white");

        var ebay_image_url = _that.parent().parent().next().next().find('img').attr('src');
        var url = $(this).prev().attr('href');
        var title = $(this).prev().text();
        var img = '<img style="width: 77px;margin-left: 233px;" src="https://loading.io/spinners/microsoft/lg.rotating-balls-spinner.gif">';
        var host = get_hostname(url);

        if(host == 'https://www.amazon.com'){
          var regex = RegExp("https://www.amazon.com/([\\w-]+/)?(dp|gp/product)/(\\w+/)?(\\w{10})");
          m = url.match(regex);

          if (m) {
            $('#outpout').html(img);
            $('#secondModal').modal('show');

            $.post('amazon.php',{asin:m[4]},function(data){
              var obj = jQuery.parseJSON(data);

              var i;
              var images;
              for (i = 0; i < obj.test.all_images.length; ++i) {                 
                 if(obj.test.all_images[i] && obj.test.all_images[i] != "" && obj.test.all_images[i] != undefined){                   
                    images += "<a target='_blank' href='"+obj.test.all_images[i]+"'>Link</a> ,";                    
                 }
              }   

              if(images.indexOf("undefined") >= 0){                
                  var data = images.split('undefined');
                  data = data[1].slice(0,-1)
                  images = data;
              }         
              
              if(obj.test.asin != ""){   
                if(obj.test.formattedPrice == ""){
                  obj.test.formattedPrice = obj.test.lowest_price;
                }

                $('#outpout').html("<p>Image :  "+images+"<br>MPN: "+obj.test.mpn_number+"<br>UPC: "+obj.test.upc+"<br>ASIN: "+obj.test.asin+"<br>Model: "+obj.test.model+"<br>Price: "+obj.test.formattedPrice+"<br>Brand: "+obj.test.brand+"<br>Title: "+obj.test.title+"<br>Description: "+obj.test.editorial_review+"<br>Category: "+obj.test.category.Ancestors.BrowseNode.Name+"</p>");
              }
              else{
                let title = _that.prev().text();
                $('#outpout').html("<p>Image : <a target='_blank' href='"+ebay_image_url+"'>Link</a><br>MPN: <br>UPC: <br>ASIN: "+m[4]+"<br>Model: <br>Price: <br>Brand: <br>Title: "+title+"<br>Description: <br>Category: </p>");
              }
            });
          }
          else{
            alert('no detail page');
          }
        }
        else{
          var url2 = get_hostname(url);

          if(url2 != 'https://www.ebay.com'){
            alert('not detail page url');
            return false;
          }else{
            parts = url.split("/"),
            last_part = parts[parts.length-1];

            var t = $.isNumeric(last_part)
            if(t && last_part.length == 12){
              $('#outpout').html(img);
              $('#secondModal').modal('show');
            
              $.post('ebay_all.php',{url:url} ,function(data){
                var obj = jQuery.parseJSON(data);
                $('#outpout').html("<p>Image : "+"<a target='_blank' href='"+ebay_image_url+"'>Link</a><br>Category ID: "+obj.test.cat_id+"<br>ePID: "+obj.test.epid+"<br>MPN: "+obj.test.mpn+"<br>UPC/EAN: "+obj.test.upc+"<br>Color: "+obj.test.color+"<br>Model: "+obj.test.model+"<br>Price: "+obj.test.list_price+"<br>Brand: "+obj.test.brand+"<br>Title: "+title+"<br>Description: "+obj.test.description+"<br>Category: "+obj.test.category+"</p>");
              });            
            }
            else{
              alert('not detail page url');
            }
          }
        }
      });

      /*** FOR GETTING HOST NAME LIKE EBAY AMAZON ETC ***/
      function get_hostname(url) {
        var m = url.match(/^https:\/\/[^/]+/);
        return m ? m[0] : null;
      }

      /*** FOR ADDING BACKGROUND COLOR ON PARTICULAR LINK WHEN MODAL OPEN ***/
      $(document).on("click", ".gs-title", function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $(document).find('.active').css("background-color","white");
        $(document).find('.activelink').css('color','black');
        $(this).closest( "div.gsc-webResult" ).addClass('active');
        $(this).closest( "div.gsc-webResult" ).css("background-color", "#ADD8E6");
        $(this).next().addClass('activelink');
        $(this).next().css('color','white');
        if(url){
          window.open(url,"_blank",
                      "toolbar,scrollbars,resizable,top=50,left=500,width=800,height=450");
        }
      });

      /*** FOR ADDING THUMB ICON ***/
      window.setInterval(function(){

        $(document).find('.gsc-inline-block').css('height','30px');
        if($('.gsc-thumbnail-inside').find('span').length == 0) {
          $('.gs-title a').each(function(){
              let url = $(this).attr('href');            
            
              $(this).after('<span class="get_url">&nbsp;&nbsp;&nbsp;&nbsp;<i onmouseover="infoTitle(this)" title="" style="text-decoration: none;float: left;margin-right: 5PX;" class="fa fa-thumbs-up"></i></span>');                         
            });
        }        
      }, 1000); 

      function infoTitle(x){        
         var url = $(x).parent().prev().attr('href');  

         if(!url){
          return "";
         }

         if($(x).parent().hasClass('done')){
            return false;
         }
         
         $(x).parent().addClass('done');

         var host = get_hostname(url);

         if(host == 'https://www.amazon.com'){
          var regex = RegExp("https://www.amazon.com/([\\w-]+/)?(dp|gp/product)/(\\w+/)?(\\w{10})");
          m = url.match(regex);

          if (m) { 
            Tipped.create(x,'Wait...');          
            $.post('amazon.php',{asin:m[4]},function(data){
              var obj = jQuery.parseJSON(data);
              
              if(obj.test.asin != ""){   
                if(obj.test.formattedPrice == ""){
                  obj.test.formattedPrice = obj.test.lowest_price;
              }

              var i;
              var images;
              for (i = 0; i < obj.test.all_images.length; ++i) {                 
                 if(obj.test.all_images[i] && obj.test.all_images[i] != "" && obj.test.all_images[i] != undefined){                   
                    images += "<a target='_blank' href='"+obj.test.all_images[i]+"'>Link</a> ,";                    
                 }
              }   

              if(images.indexOf("undefined") >= 0){                
                  var data = images.split('undefined');
                  data = data[1].slice(0,-1)
                  images = data;
              } 

              let info = 'MPN: '+obj.test.mpn_number+' UPC: ' +obj.test.upc+' ASIN: '+obj.test.asin+' Model: '+obj.test.model+' Price: '+obj.test.formattedPrice+' Brand: '+obj.test.brand+' Title: '+obj.test.title+' Description: '+obj.test.editorial_review+' Category: '+obj.test.category.Ancestors.BrowseNode.Name; 

              Tipped.create(x, info);             

              //$(x).attr('title', info);
              }else{             
                let title = "Image :  MPN:  UPC:  ASIN: "+m[4]+" Model:  Price: Brand:  Title:  Description:  Category: ";
                Tipped.create(x, title);             
                //$(x).attr('title', title);
              }
            });
          }
          else{
            Tipped.create(x, 'Not detail page url'); 
            //$(x).attr('title', 'Not detail page url');               
          }
        }
        else{
          var url2 = get_hostname(url);

          console.log('url2', url2);
          console.log('url', url);

          if(url2 != 'https://www.ebay.com'){
            Tipped.create(x, 'Not detail page url'); 
            //$(x).attr('title', 'Not detail page url');  
            return false;
          }else{
            Tipped.create(x,'Wait...');

            parts = url.split("/"),
            last_part = parts[parts.length-1];

            var t = $.isNumeric(last_part)
            if(t && last_part.length == 12){             
              $.post('ebay_all_custom.php',{url:url} ,function(data){
                var obj = jQuery.parseJSON(data);

                var i;
                var images;
                for (i = 0; i < obj.test.images.length; ++i) {                 
                   if(obj.test.images[i] && obj.test.images[i] != "" && obj.test.images[i] != undefined){                   
                      images = "<a target='_blank' href='"+obj.test.images[1]+"'>Link</a>";                    
                   }
                }   

                if(images.indexOf("undefined") >= 0){                
                    var data = images.split('undefined');
                    data = data[1].slice(0,-1)
                    images = data;
                }  
              
                let title = "Category ID: "+obj.test.cat_id+" ePID: "+obj.test.epid+" MPN: "+obj.test.mpn+" UPC/EAN: "+obj.test.upc+" Color: "+obj.test.color+" Model: "+obj.test.model+" Price: "+obj.test.list_price+" Brand: "+obj.test.brand+" Title: "+obj.test.title+" Description: "+obj.test.description+" Category: "+obj.test.category;

                Tipped.create(x, title);                 
                //$(x).attr('title',title);
              });            
            }
            else{
              Tipped.create(x, 'Not detail page url');
              //$(x).attr('title', 'Not detail page url');               
            }
          }
        }  
      }    

      /*** ADD hover class to popup a image ***/
      $("#sliderModal").mouseover(function(){
        $(this).find('.gsc-thumbnail').each(function(){
          if(!$(this).hasClass('hover')){
            $(this).addClass('hover');
          }
        });
      });
    </script>
    <script type="text/javascript" src="./common.js"></script>
    <script type="text/javascript" src="./tipped.js"></script>
  </body>
</html>
