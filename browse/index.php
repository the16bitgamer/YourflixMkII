<?php
	$phpUrl = $_SERVER['DOCUMENT_ROOT'];
	include $phpUrl.'/php/YourflixShows.php';
    
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
		<script src="..\js\YourflixNavBar.js"></script>
		<script src="..\js\YourflixVideoPage.js"></script>
	</head>
	<body id="Main_Body"class="bg-secondary">
	
		<div id="NavBar" class="fixed-top">
		</div>	
        
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
        var baseUrl = location.protocol + "//" + location.hostname+"/";
        var showPageUrl = baseUrl+"/php/YourflixShowPage.php";
        var urlParams = new URLSearchParams(window.location.search);
        var focused = false;
        var focusId = window.location.href.split("#")[1];     
        document.getElementById("PageTitle").innerHTML = "Yourflix Browse All";
        
        LoadPage();
        function LoadPage()
        {
            document.getElementById("NavBar").innerHTML = BuildNavBar(baseUrl);   
            GeneratePage();
            setTimeout(function(){
                if(!focused)
                {
                    focused = true;
                    document.getElementById(focusId).focus();
                }
            }, 500);
        }
        document.addEventListener('DOMContentLoaded', function() {
            focused = true;
            document.getElementById(focusId).focus();
        }, false);
        function GeneratePage()
		{
			var numCol = GetNumColums();
			
			Shows(numCol);
			//Recommended(numCol);
		}
    </script>
    
	<script>
        //Recomened Builder
		function Recommended(numCol)
		{				
			var cards = BuildCards(baseUrl, shows, showsImages, showsUrl, false, showsNew);
			
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
        var cards = BuildCards(baseUrl, shows, showsImages, showsUrl, true, showsNew);
        
        var showString = BuildShows("All",cards,shows,numCol);
        document.getElementById("Shows").innerHTML = showString;
        document.getElementById("Main_Body").style.overflow = "visible";
    }
    </script>
    
</html>