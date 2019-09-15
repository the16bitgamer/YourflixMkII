function BuildRecommended(showsCards,showsPerRow)
{
	var carousel = 	"<div class='border-bottom border-light'>";
	carousel += 		"<h1 class='text-white'>Recommended</h1>"
			
	carousel += 		"<div id='recom' class='carousel slide' data-ride='carousel'>";
	
	carousel += 			"<div class='carousel-inner'>";
	
	var numRows = 0;
	for(var i = 0; i < showsCards.length; i+=showsPerRow)
	{
		if(showsPerRow+i > showsCards.length)
		{
			break;
		}
		numRows++;
		if(i == 0)
		{
			carousel += 		"<div class='carousel-item active'>";
		}
		else
		{
			carousel += 			"<div class='carousel-item'>";
		}
		carousel += 					BuildCarouselRow(showsPerRow, showsCards, i);
		carousel += 				"</div>";
	}
	carousel += 				"</div>";
	if(numRows > 1)
	{
		carousel += 		BuildNavBar(numRows);
	}
	carousel += 			"</div>";
	carousel += 		"</div>";	
	carousel += 	"</div>";
	
	return carousel;
}

function BuildCarouselRow(showsPerRow, showCard, offset)
{
	var showHtml = 	"<div class='container-fluid'>";
	showHtml += 		"<div class='row shows'>";
	for (i = 0; i < showsPerRow; i++)
	{ 				
		showHtml += 		"<div class='col-sm-"+NumColumCalc(showsPerRow)+" d-flex'>";
		showHtml += 			showCard[(i+offset)];
		showHtml += 		"</div>";
	}
	showHtml += 		"</div>";
	showHtml += 	"</div>";
	return showHtml;
}

function BuildNavBar(numRows)
{
	var navString = 	"<nav class='navbar py-3'>";
	navString += 			"<ul class='carousel-indicators' style='bottom:-1em;'>";
	navString += 				"<li data-target='#recom' data-slide-to='0' class='active'></li>";
	for(var i = 1; i < numRows; i++)
	{
		navString += 			"<li data-target='#recom' data-slide-to='"+i+"'></li>";
	}
	navString += 			"</ul>";
	navString += 			"<a class='carousel-control-prev' href='#recom' data-slide='prev'>";
	navString += 				"<span class='carousel-control-prev-icon'></span>";
	navString += 			"</a>";
	navString += 			"<a class='carousel-control-next' href='#recom' data-slide='next'>";
	navString += 				"<span class='carousel-control-next-icon'></span>";
	navString += 			"</a>";
	navString += 		"</nav>";
	
	return navString;
}


function NumColumCalc(showsPerRow)
{
	return Math.round(12/showsPerRow);
}
