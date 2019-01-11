<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("p").click(function(){
        $.post('index.php',{url:'https://photos.app.goo.gl/TZFDxsZAECmdn4cs7'},function(data){
			console.log(data);	
		});	
    });
});
</script>
</head>
<body>

<p>If you click on me, I will disappear.</p>
<p>Click me away!</p>
<p>Click me too!</p>

</body>
</html>