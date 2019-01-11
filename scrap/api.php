<html>
  <head>
    <title>JSON Custom Search API Example</title>
  </head>
  <body>
  <a href="#" id="click">ci</a>
		<div style="border: 1px solid blue;">
			Area 1 (for example a sidebar)
			<gcse:searchbox></gcse:searchbox>
		</div>

		<div style="border: 1px solid red;">
			Area 2 (for example main area of the page)
			<gcse:searchresults></gcse:searchresults>
		</div>
  </body>
<script>
  (function() {
    var cx = '006084619413404036248:dl1t-ht6bbw';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $('#click').click(function() {
	var iFrameDOM = $("iframe#frameID").contents();
	console.log(iFrameDOM)
	});
  </script>
</html>