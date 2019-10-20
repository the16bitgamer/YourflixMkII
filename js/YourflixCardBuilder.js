function BuildCard(baseUrlIn, showName, showImg, showUrl, textOverflow, newShow){
    var newPage = baseUrlIn+"show/?show="+showUrl;
    
	var cardText = "<div id='"+showUrl+"' tabindex='"+showUrl+"' class='card' style='width:100%;'>";
	cardText += "<img class='card-img-top' src=\""+window.location.origin +"/"+ showImg +"\" alt='"+showName+"'>";
	cardText += "<a class='stretched-link' href="+newPage+"></a>";
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
        
function BuildCards(urlIn, showsIn, imagesIn, urlsIn,textOverflow, newShowsIn)
{
	var cardsArray = [];
    var today = new Date();
	for (i = 0; i < showsIn.length; i++)
	{
        var currDate = new Date(newShowsIn[i]);
        currDate.setDate(currDate.getDate() + 14);
        var isNew = today < currDate;
		cardsArray.push(BuildCard(urlIn, showsIn[i],imagesIn[i],urlsIn[i],textOverflow,isNew));
	}
	
	return cardsArray;
}