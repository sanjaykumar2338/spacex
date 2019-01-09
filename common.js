 $(document).on("click", "#get_url_search", function(e){
        e.preventDefault();        
        var _that = $(this);

        var ebay_image_url = _that.parent().parent().next().next().find('img').attr('src');
        var url = $('#url_search').val();

        var title = $(this).prev().text();      
        var host = get_hostname(url);

        if(host == 'https://www.amazon.com'){
          var regex = RegExp("https://www.amazon.com/([\\w-]+/)?(dp|gp/product)/(\\w+/)?(\\w{10})");
          m = url.match(regex);

          if (m) {
            $('#outpout').html('<img style="width: 77px;margin-left: 233px;" src="https://loading.io/spinners/microsoft/lg.rotating-balls-spinner.gif">');
            $('#secondModal').modal('show');

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

              $('#outpout').html("<p><b>Image : "+images+"</b><br><b>MPN: "+obj.test.mpn_number+"</b><br><b>UPC: "+obj.test.upc+"</b><br><b>ASIN: "+obj.test.asin+"</b><br><b>Model: "+obj.test.model+"</b><br><b>Price: "+obj.test.formattedPrice+"</b><br><b>Brand: "+obj.test.brand+"</b><br><b>Title: "+obj.test.title+"</b><br><b>Description: "+obj.test.editorial_review+"</b><br><b>Category: "+obj.test.category.Ancestors.BrowseNode.Name+"</b></p>");

              }else{
                let title = _that.prev().text();
                $('#outpout').html("<p><b>Image : <a target='_blank' href='"+ebay_image_url+"'>Link</a></b><br><b>MPN: </b><br><b>UPC: </b><br><b>ASIN: "+m[4]+"</b><br><b>Model: </b><br><b>Price: </b><br><b>Brand: </b><br><b>Title: "+title+"</b><br><b>Description: </b><br><b>Category: </b></p>");
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
              $('#outpout').html('<img style="width: 77px;margin-left: 233px;" src="https://loading.io/spinners/microsoft/lg.rotating-balls-spinner.gif">');
              $('#secondModal').modal('show');
            
              $.post('ebay_all_custom.php',{url:url} ,function(data){
                var obj = jQuery.parseJSON(data);

                var i;
                var images;
                for (i = 0; i < obj.test.images.length; ++i) {                 
                   if(obj.test.images[i] && obj.test.images[i] != "" && obj.test.images[i] != undefined){                   
                      images += "<a target='_blank' href='"+obj.test.images[i]+"'>Link</a> ,";                    
                   }
                }   

                if(images.indexOf("undefined") >= 0){                
                    var data = images.split('undefined');
                    data = data[1].slice(0,-1)
                    images = data;
                }  
                
                $('#outpout').html("<p><b>Image : "+images+"</b><br><b>Category ID: "+obj.test.cat_id+"</b><br><b>ePID: "+obj.test.epid+"</b><br><b>MPN: "+obj.test.mpn+"</b><br><b>UPC/EAN: "+obj.test.upc+"</b><br><b>Color: "+obj.test.color+"</b><br><b>Model: "+obj.test.model+"</b><br><b>Price: "+obj.test.list_price+"</b><br><b>Brand: "+obj.test.brand+"</b><br><b>Title: <span id='common_title'>"+obj.test.title+"</span></b><br><b>Description: "+obj.test.description+"</b><br><b>Category: "+obj.test.category+"</b></p>");
              });            
            }
            else{
              alert('not detail page url');
            }
          }
        }
});