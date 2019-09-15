<?php

    function GetShowInfo($showId, $currSeasonId)    
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
        
        $requestShow = "SELECT * FROM YourFlix_ShowInfo WHERE ShowId = '".$showId."';";
        $showResult = $conn->query($requestShow);
        $currentShow = mysqli_fetch_assoc($showResult);
        
        $Seasons = array();
        $seasonsId = array();
        $seasonName = "";
        
        if(strcmp($currentShow['ShowType'],"SHO") == 0)
        {
            $requestSeason = "SELECT * FROM YourFlix_ShowSeasons WHERE ShowId = '".$showId."' ORDER BY SeasonFolderName;";
            $resultSeason = $conn->query($requestSeason);
            
            if ($resultSeason->num_rows > 0) 
            {
                $index = 1;
                while($season = $resultSeason->fetch_assoc()) 
                {
                    if($currSeasonId == null)
                    {
                        $currSeasonId = $season['SeasonID'];
                        $seasonName = GetNonNull($season['SeasonName'], $season['SeasonFolderName']);
                    }
                    else if($currSeasonId == $season['SeasonID'])
                    {
                        $seasonName = GetNonNull($season['SeasonName'], $season['SeasonFolderName']);
                    }
                    $seasonsId[] = $season['SeasonID'];
                    $Seasons[] = GetNonNull($season['SeasonName'], $season['SeasonFolderName']);
                    $index++;
                }
            } 
            else 
            {
                echo "0 Seasons";
            }
        }
        else
        {
            $currSeasonId = "NULL";
        }
        
        $requestVideos = "SELECT * FROM YourFlix_VideoInfo WHERE ShowId = '".$showId."' AND SeasonId = \"".$currSeasonId."\" ORDER BY FileName;";
        $resultVideos = $conn->query($requestVideos);
        
        $conn->close();
        
        $showName = GetNonNull($currentShow['ShowName'], $currentShow['ShowFolderName']);
        $showImg = $currentShow['ShowImg'];
        $showDesctiption = GetNonNull($currentShow['ShowDescription'],"");
        
        $videosLoc = array();
        $videosName = array();
        $videosDescription = array();
        $videosImg = array();
        
        if ($resultVideos->num_rows > 0) 
        {
            while($video = $resultVideos->fetch_assoc()) 
            {
                $videosLoc[] = $video['VideoId'];
                $videosName[] = GetNonNull($video['VideoName'], $video['FileName']);
                $videosDescription[] = GetNonNull($video['VideoDescription'], "");
                $videosImg[] = GetNonNull($video['VideoImgLoc'], "");
            }
        } 
        else 
        {
            echo "0 Videos";
        }
        
        echo "{ \"showName\":\"". $showName ."\""
        .",\"showId\":\"". $showId ."\""
        .",\"showImg\":\"". $showImg ."\""
        .",\"showDesctiption\":\"". $showDesctiption ."\""
        .",\"videosLoc\":". json_encode($videosLoc)
        .",\"videosName\":". json_encode($videosName)
        .",\"videosDescription\":". json_encode($videosDescription)
        .",\"videosImg\":". json_encode($videosImg)
        .",\"seasonName\":\"". $seasonName ."\""
        .",\"SeasonsId\":". json_encode($seasonsId)
        .",\"Seasons\":". json_encode($Seasons)."}";
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