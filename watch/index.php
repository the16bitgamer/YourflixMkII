<?php
	$phpUrl = $_SERVER['DOCUMENT_ROOT']; 
	$url = $_SERVER['SERVER_NAME']; 
    include $phpUrl.'/php/YourflixWatch.php';
    parse_str($_SERVER["QUERY_STRING"]);
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
		<script src="..\js\YourflixVideoPage.js"></script>
		<script src="..\js\YourflixNavBar.js"></script>
	</head>
	<body id="Main_Body"class="bg-secondary">
	
		<div id="NavBar">
		</div>		
        
		<div id="VideoPlayer">
            <p>Video Failed to Load</p>
		</div>
		
		<div id="VideoControlPannel" class='bg-dark'>
            <table style="width:100%">
                <tr>
                    <th style="float: left;">
                        <button type="button" class="btn btn-danger" onclick="ReturnShowPage()">
                            <img id="BackButton" style="height:2em;"/>
                        </button>
                    </th>
                    <th style="text-align: center;">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary" onclick="SkipTimeline(-10)">-10</button>
                            <button type="button" class="btn btn-primary" onclick="PlayVideo()">
                                <img id="PlayButton" style="width=2em; height:2em;"/>
                            </button>
                            <button type="button" class="btn btn-primary" onclick="SkipTimeline(10)">10+</button>
                        </div>
                    </th>
                    <th style="float: right;">
                        <button type="button" class="btn btn-primary">
                                <img id="FullButton" style="height:2em;" onclick="OpenFullscreen()"/>
                        </button>
                    </th>
                </tr>          
            </table>
		</div>
	</body>
	
    <script type="text/javascript">
        window.onload = LoadPage;
		window.onresize = UpdateVideoSize;
        
        var baseUrl = <?php echo "\"http://".$url."/\""; ?>;
        
        var playButton = document.getElementById("PlayButton");        
        var playImg = baseUrl+"img/PlayVideo.png";
        var pauseImg = baseUrl+"img/PauseVideo.png";
        var fullImg = baseUrl+"img/FullScreenVideo.png";
        var backImg = baseUrl+"img/Back Arrow.png";
        
        playButton.src = playImg;
        document.getElementById("FullButton").src = fullImg;
        document.getElementById("BackButton").src = backImg;
        
        var videoData = <?php echo GetShow($video); ?>; 
        document.getElementById("NavBar").innerHTML = BuildVideoNavBar(baseUrl, videoData.videoName, videoData.showId, videoData.nextVideo, videoData.prevVideo);        
        document.getElementById("PageTitle").innerHTML = "Yourflix Watch: " + videoData.videoName;
        
        var home = baseUrl+"/show/?show=" + videoData.showId;
        if(videoData.seasonId != "")
        {
            home += "&season=" + videoData.seasonId;
        }
        
        LoadPage();
        function LoadPage()
        {
            VideoPage();
        }
    </script>
    
    <script type="text/javascript">
        var videoWindow = null;
    
        function PlayVideo()
        {
            if(videoWindow == null)
            {
                videoWindow = document.getElementById("Video");
            }
            
            if (videoWindow.paused)
            {
                videoWindow.play(); 
                playButton.src = pauseImg;
            }
            else
            { 
                videoWindow.pause(); 
                playButton.src = playImg;
            } 
        }
        
        function SkipTimeline(timeJumped)
        {
            if(videoWindow == null)
            {
                videoWindow = document.getElementById("Video");
            }
            videoWindow.currentTime = videoWindow.currentTime + timeJumped;
        }
        
        function ReturnShowPage()
        {
            window.location.href = home;
        }
        
        function OpenFullscreen() 
        {
            if(videoWindow == null)
            {
                videoWindow = document.getElementById("Video");
            }
            if (videoWindow.requestFullscreen) {
                videoWindow.requestFullscreen();
            } 
            else if (videoWindow.mozRequestFullScreen) 
            { /* Firefox */
                videoWindow.mozRequestFullScreen();
            }
            else if (videoWindow.webkitRequestFullscreen) 
            { /* Chrome, Safari and Opera */
                videoWindow.webkitRequestFullscreen();
            }
            else if (videoWindow.msRequestFullscreen) 
            { /* IE/Edge */
                videoWindow.msRequestFullscreen();
            }
        }
    </script>
    
    <script type="text/javascript">
        
        function VideoPage()
        {
            document.getElementById("VideoPlayer").innerHTML = BuildVideoPage(baseUrl+videoData.videoLoc);
            document.getElementById("Main_Body").style.overflow = "hidden"
            var previousOrientation = window.orientation;
            var checkOrientation = function(){
                if(window.orientation !== previousOrientation){
                    previousOrientation = window.orientation;
                    UpdateVideoSize(baseUrl+videoData.videoLoc)
                }
            };

            window.addEventListener("resize", checkOrientation, false);
            window.addEventListener("orientationchange", checkOrientation, false);

            setInterval(checkOrientation, 2000);
        }
    </script>
    
</html>