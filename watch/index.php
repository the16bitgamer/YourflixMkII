<?php
	$phpUrl = $_SERVER['DOCUMENT_ROOT']; 
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
                    <th style="float: left; width:30%;">
                        <button type="button" class="btn btn-danger" onclick="ReturnShowPage()">
                            <img id="BackButton" style="height:2em;"/>
                        </button>
                    </th>
                    <th style="text-align: center; width:40%;">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary" onclick="SkipTimeline(-10)">-10</button>
                            <button type="button" class="btn btn-primary" onclick="PlayVideo()">
                                <img id="PlayButton" style="width=2em; height:2em;"/>
                            </button>
                            <button type="button" class="btn btn-primary" onclick="SkipTimeline(10)">10+</button>
                        </div>
                    </th>
                    <th style="text-align: right; width:30%;">
                        <button type="button" id='AutoPlay' class="btn text-white" style="background-color:"+currColor+";" onclick='SetAutoPlay()'>
                            AutoPlay
                        </button>
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
        
        var baseUrl = location.protocol + "//" + location.hostname+"/";
        
        var playButton = document.getElementById("PlayButton");        
        var playImg = baseUrl+"img/PlayVideo.png";
        var pauseImg = baseUrl+"img/PauseVideo.png";
        var fullImg = baseUrl+"img/FullScreenVideo.png";
        var backImg = baseUrl+"img/Back Arrow.png";
        
        playButton.src = playImg;
        document.getElementById("FullButton").src = fullImg;
        document.getElementById("BackButton").src = backImg;
        
        var videoData = <?php echo GetShow($video); ?>;
        var canAutoPlay = videoData.nextVideo != "" || videoData.prevVideo != "";
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
        var autoPlay = ('true' == localStorage['autoPlay']);
        var autoOff = "#ff0000";
        var autoOn = "#0000ff";
        var currColor = autoOff;    
        
        if(autoPlay)
        {
            currColor = autoOn;
        }
        document.getElementById("AutoPlay").style.background = currColor;
    
        function PlayVideo()
        {
            if(videoWindow == null)
            {
                SetVideoWindow();
            }
            
            if (videoWindow.paused)
            {
                videoWindow.play(); 
            }
            else
            { 
                videoWindow.pause(); 
            } 
            UpdateVideoState();
        }
        
        function UpdateVideoState()
        {
            if(videoWindow == null)
            {
                SetVideoWindow();
            }
            if (!videoWindow.paused)
            {
                playButton.src = pauseImg;
            }
            else
            { 
                playButton.src = playImg;
            } 
        }
        
        function SkipTimeline(timeJumped)
        {
            if(videoWindow == null)
            {
                SetVideoWindow();
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
                SetVideoWindow();
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
        
        function SetVideoWindow()
        {
            if(canAutoPlay)
            {
                videoWindow = document.getElementById("Video");
                videoWindow.addEventListener('ended',WhenVideoEnds,false);
                function WhenVideoEnds(e)
                {
                    AutoPlay();
                }
            }
        }
        
        function SetAutoPlay()
        {
            autoPlay = !autoPlay;
            if(autoPlay)
            {
                currColor = autoOn;
            }
            else
            {
                currColor = autoOff;
            }
            localStorage['autoPlay'] = autoPlay.toString();
            document.getElementById("AutoPlay").style.background = currColor;
        }
        
        function AutoPlay()
        {
            window.location.href = (baseUrl+"watch/?video="+videoData.nextVideo);
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
            SetVideoWindow();
        }
    </script>
    
</html>