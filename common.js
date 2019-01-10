 $(document).on("click", "#get_url_search", function(e){
        e.preventDefault();        
        var _that = $(this);

        var ebay_image_url = ""
        var url = $('#url_search').val();
		
    		if(!url){
    			alert('Enter URL');
    			return false;
    		}

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

              $('#outpout').html("Image : "+images+"<br>MPN: "+obj.test.mpn_number+"<brUPC: "+obj.test.upc+"<br>ASIN: "+obj.test.asin+"<br>Model: "+obj.test.model+"<br>Price: "+obj.test.formattedPrice+"<br>Brand: "+obj.test.brand+"<br>Title: "+obj.test.title+"<br>Description: "+obj.test.editorial_review+"<br>Category: "+obj.test.category.Ancestors.BrowseNode.Name);

              }else{
                let title = _that.prev().text();
                $('#outpout').html("MPN:  UPC:  ASIN: "+m[4]+" Model:  Price:  Brand:  Title:  Description:  Category: ");
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
                      images = "<a target='_blank' href='"+obj.test.images[1]+"'>Link</a>";                    
                   }
                }   

                if(images.indexOf("undefined") >= 0){                
                    var data = images.split('undefined');
                    data = data[1].slice(0,-1)
                    images = data;
                }  
                
                $('#outpout').html("Image : "+images+"<br>Category ID: "+obj.test.cat_id+"<br>ePID: "+obj.test.epid+"<br>MPN: "+obj.test.mpn+"<br>UPC/EAN: "+obj.test.upc+"<br>Color: "+obj.test.color+"<br>Model: "+obj.test.model+"<br>Price: "+obj.test.list_price+"<br>Brand: "+obj.test.brand+"<br>Title: <span id='common_title'>"+obj.test.title+"</span><br>Description: "+obj.test.description+"<br>Category: "+obj.test.category);
              });            
            }
            else{
              alert('not detail page url');
            }
          }
        }
  });