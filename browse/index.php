<?php
	$url = $_SERVER['DOCUMENT_ROOT'];
	include $url.'/php/YourflixShows.php';
    
?>

<html lang ="en">
	<head>
        <title id="PageTitle">Yourflix Browse</title>
		<meta charset="uft-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="../img/YourFlix.png"/>
		<link rel="stylesheet" href="..\css\bootstrap.min.css">
		<link rel="stylesheet" href="..\css\Yourflix.css">
		<script src="..\js\jquery-3.4.1.min.js"></script>
		<script src="..\js\popper.min.js"></script>
		<script src="..\js\bootstrap.min.js"></script>
		<script src="..\js\YourflixCardBuilder.js"></script>
		<script src="..\js\YourflixShowBuilder.js"></script>
		<script src="..\js\YourflixRecommendedBuilder.js"></script>
		<script src="..\js\YourflixRowSizes.js"></script>
		<script src="..\js\YourflixShowPage.js"></script>
		<script src="..\js\YourflixVideoPage.js"></script>
	</head>
	<body id="Main_Body"class="bg-secondary">
	
		<nav id="NavBar" class='navbar navbar-expand-md navbar-dark bg-dark sticky-top'>
			<?php include $url.'/php/YourflixNavBar.php';?>
		</nav>
        
		<div id="Recommended">			
		</div>
		
		<div id="Shows">
		</div>
        
		<div id="myNav">
        </div>
	</body>
	
    <script>
        window.onload = LoadPage;
		window.onresize = GeneratePage;
        var baseUrl = <?php echo "\"http://".$url."/\""; ?>;
        var showPageUrl = baseUrl+"/php/YourflixShowPage.php";
        var urlParams = new URLSearchParams(window.location.search);
        
        document.getElementById("PageTitle").innerHTML = "Yourflix Browse All";
        
        LoadPage();
        function LoadPage()
        {
            GeneratePage();
        }
        
        function GeneratePage()
		{
			var numCol = GetNumColums();
			
			Shows(numCol);
			//Recommended(numCol);
		}
    </script>
    
    <script>
        function LoadShowPage(showID)
        {
            window.location.href = baseUrl+"show/?show="+showID;
        }
    </script>
    
	<script>
        //Recomened Builder
		function Recommended(numCol)
		{				
			var cards = BuildCards(shows, showsImages, showsUrl, false, showsNew);
			
			var recommendedString = BuildRecommended(cards,numCol);
			document.getElementById("Recommended").innerHTML = recommendedString;
		}
	</script>
    
    <script type="text/javascript">
    function ShowPage(currShowData, showID)
    {
        document.getElementById("myNav").innerHTML = BuildShowPage(baseUrl, currShowData.showName, currShowData.showImg, currShowData.videosLoc, currShowData.showDesctiption, currShowData.videosName, currShowData.videosDescription, currShowData.Seasons, currShowData.currentSeason, currShowData.videosImg, showID);
    }
    </script>
    
    <script type="text/javascript">
    var shows = <?php echo $shows->GetShowNames();?>;
    var showsImages =  <?php echo $shows->GetShowImg();?>;
    var showsUrl =  <?php echo $shows->GetShowIds();?>;
    var showsNew =  <?php echo $shows->GetNewShows();?>;
    
    function Shows(numCol)
    {
        var cards = BuildCards(shows, showsImages, showsUrl, true, showsNew);
        
        var showString = BuildShows("All",cards,shows,numCol);
        document.getElementById("Shows").innerHTML = showString;
        document.getElementById("Main_Body").style.overflow = "visible";
    }
    </script>
    
</html>