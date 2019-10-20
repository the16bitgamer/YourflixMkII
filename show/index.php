<?php
	$phpUrl = $_SERVER['DOCUMENT_ROOT'];
    include $phpUrl.'/php/YourflixShowPage.php';
    parse_str($_SERVER["QUERY_STRING"]);
    if(!isset($season))
    {
        $season = null;
    }
?>

<html lang ="en">
	<head>
        <title id="PageTitle">Yourflix Show</title>
		<meta charset="uft-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="../img/YourFlix.png"/>
		<link rel="stylesheet" href="..\css\bootstrap.min.css">
		<link rel="stylesheet" href="..\css\Yourflix.css">
		<script src="..\js\jquery-3.4.1.min.js"></script>
		<script src="..\js\popper.min.js"></script>
		<script src="..\js\bootstrap.min.js"></script>
		<script src="..\js\YourflixNavBar.js"></script>
		<script src="..\js\YourflixShowPage.js"></script>
	</head>
	<body id="Main_Body"class="bg-secondary">
	
        <div id="NavBar">
        </div>
        <div id="ShowBar">
        </div>
        <div id="ShowDetails">
        </div>
        <div id="VideoList">
        </div>
        
	</body>
	
    <script type="text/javascript">
        window.onload = LoadPage;
		//window.onresize = LoadPage;
        
        var baseUrl = location.protocol + "//" + location.hostname+"/";
        
        var showData = <?php echo GetShowInfo($show, $season); ?>;    

        document.getElementById("NavBar").innerHTML = BuildNavBar(baseUrl);
        document.getElementById("PageTitle").innerHTML = "Yourflix Show: " + showData.showName;
        
        var home = baseUrl+"/browse/";
        
        LoadPage();
        function LoadPage()
        {

            document.getElementById("ShowBar").innerHTML = BuildShowBar(baseUrl, showData.showName, showData.showId, showData.seasonName, showData.SeasonsId, showData.Seasons);
            document.getElementById("ShowDetails").innerHTML = BuildShowDetails(baseUrl, showData.showDesctiption, showData.showImg);
            document.getElementById("VideoList").innerHTML = BuildVideoList(baseUrl, showData.videosLoc, showData.videosName, showData.videosDescription, showData.videosImg);
        }
    </script>
    
</html>