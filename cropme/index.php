<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />
  <script type="text/javascript" src="scripts/jquery.min.js"></script>
  <script type="text/javascript" src="scripts/jquery.imgareaselect.pack.js"></script>
  <script src='https://cdn.jsdelivr.net/gh/naptha/tesseract.js@v1.0.14/dist/tesseract.min.js'></script>
</head>
<body>
<div class="container">
	<div id="log"></div>
	<a id="get_result" href="#">Get Result</a>
	<p>
	<img id="ferret" onclick="recognizeFile('http://moxycrm.com/images/bg-heading-02.jpg')" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/UPC-A-036000291452.svg/1200px-UPC-A-036000291452.svg.png" alt="It's coming right for us!" title="It's coming right for us!" style="float: left; margin-right: 10px;width: 250px;">
	</p>
</div>

</body>
<script type="text/javascript">	
	$('#get_result').click(function(e){
		e.preventDefault();
		$.post('saveimg.php',{url:'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/UPC-A-036000291452.svg/1200px-UPC-A-036000291452.svg.png'},function(data){
			console.log(data);
			recognizeFile(data);
		});
	});

	function preview(img, selection) {		
	    var scaleX = 100 / (selection.width || 1);
	    var scaleY = 100 / (selection.height || 1);
	  
	    $('#ferret + div > img').css({
	        width: Math.round(scaleX * 400) + 'px',
	        height: Math.round(scaleY * 300) + 'px',
	        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
	        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	    });
	}

	$(document).ready(function () {
	    $('<div><img src="bar.png" class="active" id="main_task" style="position: relative;" /><div>')
	        .css({
	            float: 'left',
	            position: 'relative',
	            overflow: 'hidden',
	            width: '100px',
	            height: '100px'
	        })
	        .insertAfter($('#ferret'));

		$('#ferret').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview });	
	});

function recognizeFile(data){
	var file = './gotit/'+data;

	//document.querySelector("#log").innerHTML = ''
	Tesseract.recognize(file, {
		lang: 'eng'
	})
		.progress(function(packet){
			progressUpdate(packet)
		})
		.then(function(data){
			alert(data.text);
			
			progressUpdate({ status: 'done', data: data })
		})
}	

function progressUpdate(packet){	
		var line = document.createElement('div');
		line.status = packet.status;
		var status = document.createElement('div')
		status.className = 'status'
		status.appendChild(document.createTextNode(packet.status))
		line.appendChild(status)
		if('progress' in packet){
			var progress = document.createElement('progress')
			progress.value = packet.progress
			progress.max = 1
			line.appendChild(progress)
		}
		if(packet.status == 'done'){
			var pre = document.createElement('pre')
			pre.appendChild(document.createTextNode(packet.data.text))
			line.innerHTML = ''
			line.appendChild(pre)
		}
		//log.insertBefore(line, log.firstChild)	
}

</script>
</html>
