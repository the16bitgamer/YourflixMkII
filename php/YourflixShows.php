<?php
    $currentTime = date("Y-m-d G:i:s");
	$url = $_SERVER['DOCUMENT_ROOT'];
	
	$servername = "localhost";
	$username = "pi";
	$password = "raspberry";
	$dbname = "Pi_YourFlix_Data";
	
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$request = "SELECT * FROM YourFlix_ShowInfo ORDER BY ShowFolderName;";
	$result = $conn->query($request);
	$conn->close();

	$recomended = new Shows();
	$shows = new Shows();

	if ($result->num_rows > 0) 
	{
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
			$shows->AddShow($row); 
		}
	} 
	else 
	{
		echo "0 results";
	}

    $numOfShows = $shows->NumberOfShows();
    //$shows->GetShowNames();
	
	class Shows { 
	
		private $allShows = array();
		private $sorted = false;
		
		public function AddShow($showIn) 
		{ 
			$this->allShows[] = $showIn;
		}
		
		public function NumberOfShows()
		{
			if(!$this->sorted)
			{
                $this->sorted = true;
			}
			return count($this->allShows);
		}
        
        public function GetShowNames()
        {
            $showNames = array();
            foreach ($this->allShows as $currShow){
                $showName = $currShow['ShowName'];
                if($showName == NULL)
                {
                    $showName = $currShow['ShowFolderName'];
                }
                $showNames[] = $showName;
            }
            
            $myJSON = json_encode($showNames);
            return $myJSON;
        }
        
        public function GetShowIds()
        {
            $ShowId = array();
            foreach ($this->allShows as $currShow)
            {

                $ShowId[] = $currShow['ShowId'];
            }
            
            $myJSON = json_encode($ShowId);
            return $myJSON;
        }
        
        public function GetShowTypes()
        {
            $ShowType = array();
            foreach ($this->allShows as $currShow)
            {

                $ShowType[] = $currShow['ShowType'];
            }
            
            $myJSON = json_encode($ShowType);
            return $myJSON;
        }
        
        public function GetShowDescriptions()
        {
            $ShowDescription = array();
            foreach ($this->allShows as $currShow)
            {
                if($currShow['ShowDescription'] != NULL)
                {
                    $ShowDescription[] = $currShow['ShowDescription'];
                }
            }
            $myJSON = json_encode($ShowDescription);
            return $myJSON;
        }
        
        public function GetShowImg()
        {
            $ShowImg = array();
            foreach ($this->allShows as $currShow)
            {

                $ShowImg[] = $currShow['ShowImg'];
            }
            
            $myJSON = json_encode($ShowImg);
            return $myJSON;
        }
        
        public function GetNewShows()
        {
            $LastUpdated = array();
            foreach ($this->allShows as $currShow)
            {
                $LastUpdated[] = $currShow['LastUpdated'];
            }
            
            $myJSON = json_encode($LastUpdated);
            return $myJSON;
        }
	} 
?>