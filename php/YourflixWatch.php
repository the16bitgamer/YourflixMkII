<?php    
    function GetShow($videoId)
    {
        $servername = "localhost";
        $username = "pi";
        $password = "raspberry";
        $dbname = "Pi_YourFlix_Data";
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $requestVideo = "SELECT * FROM YourFlix_VideoInfo WHERE VideoId = '".$videoId."';";
        $resultVideo = $conn->query($requestVideo);
        $currentVideo = mysqli_fetch_assoc($resultVideo);
        
        $seasonId = GetNonNull($currentVideo['SeasonId'], NULL);
        $prevVideo = null;
        $nextVideo = null;
            
        if(strcmp($seasonId,"NULL") != 0)
        {
            $requestEpisodes = "SELECT * FROM YourFlix_VideoInfo WHERE SeasonId = \"".$seasonId."\" ORDER BY FileName;";
            $resultEpisodes = $conn->query($requestEpisodes);
            
            if ($resultEpisodes->num_rows > 0) 
            {
                $next = false;
                $isNext = false;
                while($video = $resultEpisodes->fetch_assoc()) 
                {
                    $currId = $video['VideoId'];
                    if($currId == $videoId)
                    {
                        $next = true;
                    }
                    if($next)
                    {
                        if($isNext)
                        {
                            $nextVideo = $currId;
                            break;
                        }
                        $isNext = true;
                    }
                    else
                    {
                        $prevVideo = $currId;
                    }
                }
            } 
            else 
            {
                echo "0 Episodes";
            }
        }
        
        $requestSeason = "SELECT * FROM YourFlix_ShowSeasons WHERE SeasonID = '".$seasonId."';";
        $resultSeason = $conn->query($requestSeason);
        $seasonName = "";
           
        if ($resultSeason->num_rows > 0) 
        {
            $currentSeason = mysqli_fetch_assoc($resultSeason);
            $seasonName = GetNonNull($currentSeason['SeasonName'], $currentSeason['SeasonFolderName']);
        }
        
        $videoName = GetNonNull($currentVideo['VideoName'], $currentVideo['FileName']);
        $videoImg = GetNonNull($currentVideo['VideoImgLoc'], "");
        $videoLoc = $currentVideo['VideoLoc'];
        $seasonId = GetNonNull($currentVideo['SeasonId'],"");
        
        $showId = $currentVideo['ShowId'];
        
        return "{\"videoName\":\"". $videoName ."\""
        .",\"videoId\":\"". $videoId ."\""
        .",\"videoImg\":\"". $videoImg ."\""
        .",\"videoLoc\":\"". $videoLoc ."\""
        .",\"showId\":\"". $showId ."\""
        .",\"seasonName\":\"". $seasonName ."\""
        .",\"seasonId\":\"". $seasonId ."\""
        .",\"nextVideo\":\"". $nextVideo ."\""
        .",\"prevVideo\":\"". $prevVideo."\"}";
    }
    function GetNonNull($var1, $var2)
    {
        if($var1 != NULL)
        {
            return $var1;
        }
        return $var2;
    }
    ?>