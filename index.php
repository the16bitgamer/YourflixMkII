<html lang ="en">
	<head>
		<meta charset="uft-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="../img/YourFlix.png"/>
		<link rel="stylesheet" href="..\css\bootstrap.min.css">
		<link rel="stylesheet" href="..\css\Yourflix.css">
		<script src="..\js\jquery-3.4.1.min.js"></script>
		<script src="..\js\popper.min.js"></script>
		<script src="..\js\bootstrap.min.js"></script>
	</head>
	
	<body id="Main_Body"class="bg-secondary">
		<div class="text-center" style="max-height:75%;">
			<img src="./img/YourFlix 1080p.png" style="height:100%; width: 100%; object-fit: contain;">
		</div>
		<div class="d-flex justify-content-center">
			<div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
			  <span class="sr-only">Loading...</span>
			</div>
		</div>
		<div id="ConsoleMessage" class="text-center text-light" style="max-height:75%;">
			Checking Last Update
		</div>
		<script type="text/javascript">
            var baseUrl = location.protocol + "//" + location.hostname+"/";
			var mainPage = baseUrl+"/browse";
			
			var xmlhttp = new XMLHttpRequest();
			var lastCheckhttp = new XMLHttpRequest();
			var updateXml = new XMLHttpRequest();
            var urlParams = new URLSearchParams(location.search);
            
            var forced = false;
            
            if(urlParams.has('force'))
            {
                forced = urlParams.get('force');
            }
            
			xmlhttp.open("GET", "php/getLastUpdated.php", true);
			lastCheckhttp.open("GET", "php/getVideosSize.php", true);
			updateXml.open("GET", "php/updateDatabase.php", true);
			
			lastCheckhttp.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200)
				{
					if(parseInt(this.responseText) == 0)
					{
						document.getElementById("ConsoleMessage").innerHTML = "Updating Database. Please Wait";
						updateXml.send();
					}
					else
					{
						document.getElementById("ConsoleMessage").innerHTML = "Check for Update";
						xmlhttp.send();
					}
				}
			}
			
			xmlhttp.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200)
				{
                    var notSent = true;
					if(this.responseText == "True")
					{
						document.getElementById("ConsoleMessage").innerHTML = "Updating Database. Please Wait";
                        notSent = false;
						updateXml.send();
					}
                    
                    window.location.href = mainPage;
				}
			}
			
			updateXml.onreadystatechange = function () {
				if (this.readyState == 4 && this.status == 200) 
				{
						window.location.href = mainPage;
				}
			}
			
            
            if(!forced)
            {
                lastCheckhttp.send();
            }
            else
            {
				document.getElementById("ConsoleMessage").innerHTML = "Force Updating Database. Please Wait";
				updateXml.send();
            }
		</script>
	</body>
</html>