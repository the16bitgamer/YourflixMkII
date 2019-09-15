function BuildVideoPage(videoLoc)
{
	var height= Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
	var navSize = height - document.getElementById("NavBar").clientHeight - document.getElementById("VideoControlPannel").clientHeight;
	var videoPlayer =	"<video class='videoPlayer' id='Video' style='height:"+(navSize)+"px;' controls>";
	videoPlayer +=				"<source src=\""+videoLoc+"\" type='video/mp4'>";
	videoPlayer +=		"</video>";
	return videoPlayer;
}

function UpdateVideoSize()
{
	var height= Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
	var navSize = window.innerHeight - document.getElementById("NavBar").clientHeight - document.getElementById("VideoControlPannel").clientHeight;
	console.log(navSize);
	document.getElementById("Video").style.height = navSize + "px";
}