var nextSeason = "";
var previousSeason = "";

function BuildShowBar(baseUrl, ShowName, ShowId, SeasonName, seasonIdArray, seasonsNamesArray)
{
    var showBar = "<table style=\"width:100%\">";
    showBar += "<tr>";
    
    //Back Button
    showBar += "<th style=\"width:10%\">";
    showBar += "<a href=\""+baseUrl+"browse/#"+ShowId+"\"> <button type=\"button\" class=\"btn btn-danger\">";
    showBar += "<img src=\""+baseUrl+"img/Back%20Arrow.png\" style=\"height:1.5em;\"/>";
    showBar += "</button></a>";
    showBar += "</th>";
    
    //Show Name
    showBar += "<th style=\"text-align: center;\">";
    showBar += "<p class=\"text-white\" style=\"font-size:2vw; margin-top:0px;\">"+ShowName+"</p>";
    showBar += "</th>";
    
    if(seasonIdArray.length > 1)
    {
        //Previous Season
        showBar += "<th style=\"text-align: right; width:1%;\">";
        showBar += "<button type=\"button\" class=\"btn btn-primary\" onclick=\"SelectNextSeason(false)\">";
        showBar += "<img src=\""+baseUrl+"/img/Left%20Arrow.png\" style=\"height:1.5em;\"/>";
        showBar += "</button>";
        showBar += "</th>";
        
        //DropDown Menu
        showBar += "<th style=\"text-align: right; width:1%;\">";
        showBar += "<div class=\"dropdown\">";
        showBar += "<button class=\"btn bg-yourflix dropdown-toggle text-white\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
        showBar += SeasonName;
        showBar += "</button>";
        showBar += BuildSeasonsDropDown(baseUrl, ShowId, SeasonName, seasonIdArray, seasonsNamesArray);
        showBar += "</div>";
        showBar += "</th>";
        
        //Next Season
        showBar += "<th style=\"text-align: right; width:1%;\">";
        showBar += "<button type=\"button\" class=\"btn btn-primary\" onclick=\"SelectNextSeason(true)\">";
        showBar += "<img src=\""+baseUrl+"img/Right%20Arrow.png\" style=\"height:1.5em;\"/>";
        showBar += "</button>";
        showBar += "</th>";
    }
    showBar += "</tr>";
    showBar += "</table>";
    
    return showBar;
}

function SelectNextSeason(next)
{
    var selectSeason = previousSeason;
    if(next)
    {
        selectSeason = nextSeason;
    }
    window.location.href = selectSeason;
}

function BuildSeasonsDropDown(baseUrl, showId, SeasonName, seasonsIn, seasonsNames)
{
    var seasons = "<div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"dropdownMenuButton\">";
	for(var i = 0; i < seasonsNames.length; i++)
	{
		if(SeasonName == seasonsNames[i])
		{
			seasons += "<a class=\"dropdown-item active\"";
            var prev = (i-1+seasonsNames.length)%seasonsNames.length;            
            var next = (i+1)%seasonsNames.length;
            
            previousSeason = baseUrl+"show/?show="+showId+"&season="+seasonsIn[prev];
            nextSeason = baseUrl+"show/?show="+showId+"&season="+seasonsIn[next];
		}
		else
		{			
			seasons += "<a class=\"dropdown-item\"";
		}
		seasons += "onclick=\"window.location.href = '"+baseUrl+"show/?show="+showId+"&season="+seasonsIn[i]+"'\">";
        seasons += seasonsNames[i];
        seasons += "</a>";
	}
    seasons += "</div>";
	
	return seasons;
}

function BuildShowDetails(baseUrl, ShowDecription, ShowImg)
{
    var showDetails = "<table style=\"width:100%\">";
    showDetails += "<tr>";
    showDetails += "<th>";
    showDetails += "<p class=\"text-white\">";
    showDetails += ShowDecription;
    showDetails += "</p>";
    showDetails += "</th>";
    showDetails += "<th style=\"float: right; padding-top:1px;\">";
    showDetails += "<img src=\""+baseUrl+ShowImg+"\"/>";
    showDetails += "</th>";
    showDetails += "</tr>";
    showDetails += "</table>";
    
    return showDetails;
}

function BuildVideoList(baseUrl, VideoIdArray, VideoNameArray, VideoDescriptionArray, VideoImgArray)
{
    var videos = "";
    for(var i = 0; i < VideoIdArray.length; i++)
    {
        videos += BuildVideoElement(baseUrl, VideoIdArray[i], VideoNameArray[i], VideoDescriptionArray[i], VideoImgArray[i]);
    }
    return videos;
}

function BuildVideoElement(baseUrl, videoId, VideoName, VideoDecription, VideoImg)
{
    var videoElement = "<div style=\"border-top: 0.1em solid white;\">";
    videoElement += "<table style=\"width:100%\">";
    videoElement += "<tr>";
    videoElement += "<th style=\"width:1%\">";
    videoElement += "<button class=\"btn bg-yourflix rounded-circle btn-circle float-left\" style=\"border: 0.25em solid white;\" onclick=\"window.location.href = '"+baseUrl+"watch/?video="+videoId+"'\">";
    videoElement += "<img class=\"btn-circle-image\" src=\""+baseUrl+"img/Play.png\"/>";
    videoElement += "</button>";
    videoElement += "</th>";
    videoElement += "<th>";
    videoElement += "<h2 class=\"text-white text-left\">";
    videoElement += VideoName;
    videoElement += "</h2>";
    videoElement += "<p>";
    videoElement += VideoDecription;
    videoElement += "</p>";
    videoElement += "</th>";
    videoElement += "<th style=\"float: right;\">";
    videoElement += "<img src=\""+VideoImg+"\"/>";
    videoElement += "</th>";
    videoElement += "</tr>";
    videoElement += "</table>";
    videoElement += "</div>";
    
    return videoElement;
}