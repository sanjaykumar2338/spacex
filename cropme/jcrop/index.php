<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" /> 
		<title>Jcrop &raquo; Tutorials &raquo; Hello World</title>
		<script src="http://deepliquid.com/projects/Jcrop/js/jquery.min.js"></script>
		<script src="http://deepliquid.com/projects/Jcrop/js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="http://deepliquid.com/projects/Jcrop/css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="http://deepliquid.com/projects/Jcrop/demos/demo_files/demos.css" type="text/css" />
		<script type="text/javascript">

		jQuery(function(){
			jQuery('#cropbox').Jcrop({
				onSelect: selectedCoordinates,
	            onChange: changingCoordinates,
	            onRelease: finalCoordinates,
			});
		});

		function selectedCoordinates(c)
	    {
	    	console.log('c',c);
	      // variables can be accessed here as
	      // c.x, c.y, c.x2, c.y2, c.w, c.h
	    }

	    function changingCoordinates(c)
	     {
	      // variables can be accessed here as
	      // c.x, c.y, c.x2, c.y2, c.w, c.h
	    }

	    function finalCoordinates(c)
	     {
	      // variables can be accessed here as
	      // c.x, c.y, c.x2, c.y2, c.w, c.h
	    }


		</script>
	</head>

	<body>
		<div id="outer">
		<div class="jcExample">
		<div class="article">

			<h1>Jcrop - Hello World</h1>
			<img src="http://deepliquid.com/Jcrop/demos/demo_files/pool.jpg" id="cropbox" />

			<p>
				<b>This example is provided as a demo of the default behavior of Jcrop.</b>
				Since no event handlers have been attached it only performs
				the cropping behavior.
			</p>

			<div id="dl_links">
				<a href="http://deepliquid.com/content/Jcrop.html">Jcrop Home</a> |
				<a href="http://deepliquid.com/content/Jcrop_Manual.html">Manual (Docs)</a>
			</div>

		</div>
		</div>
		</div>
	</body>
</html>

