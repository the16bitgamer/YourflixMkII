function BuildCard(showName, showImg, showUrl, textOverflow, newShow){
	var cardText = "<div id='"+showUrl+"' class='card' style='width:100%;'>";
	cardText += "<img class='card-img-top' src=\""+window.location.origin +"/"+ showImg +"\" alt='"+showName+"'>";
	cardText += "<a class='stretched-link' onclick='LoadShowPage("+showUrl+")'></a>";
	cardText += "<h4 class='card-title pl-3 ";
	if(!textOverflow)
	{
		cardText += "text-truncate";
	}
	cardText += "'>";
	if(newShow)
	{
		cardText += "<span class='badge badge-primary float-right'>New</span>";
	}
	cardText += showName+"</h4>";
	cardText += "</div>";
	
	return cardText;
}

function BuildCards(showsIn, imagesIn, urlsIn,textOverflow, newShowsIn)
{
	var cardsArray = [];
	for (i = 0; i < showsIn.length; i++)
	{
		cardsArray.push(BuildCard(showsIn[i],imagesIn[i],urlsIn[i],textOverflow,newShowsIn[i]));
	}
	
	return cardsArray;
}