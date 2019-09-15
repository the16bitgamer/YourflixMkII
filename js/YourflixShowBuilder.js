function BuildShows(showType,showCard,shows,showsPerRow)
{
	var showHtml = "<h1 class='text-white'>"+showType+"</h1>";
	var firstChar = "";
	var position = 0;
    
    var showWidth = NumColumCalc(showsPerRow);
    var bootstrap = true;
    var showRowHeader = "<div class='container-fluid'><div class='row shows'>";
    var showRowFooter = "</div></div>";
    var showHeader = "<div class='col-sm-"+showWidth+" d-flex'>";
    var showFooter = "</div>";
    
    var platform = navigator.platform;
    
    switch(platform) {
        case "PlayStation Vita":
            showsPerRow = 4;
        case "New Nintendo 3DS":
            bootstrap = false;
            showWidth = (1/showsPerRow)*100;
            showRowHeader = "<div class='shows' style='overflow: auto; clear: both;'>";
            showRowFooter = "</div>";
            showHeader = "<div style='width:"+showWidth+"%; float: left;'>";
            showFooter = "</div>";
            break;
    }
    
	for (i = 0; i < shows.length; i++)
	{   
        var currChar = shows[i].charAt(0).toUpperCase();
        if(currChar != firstChar)
        {
            firstChar = currChar;
            if(position != 0)
            {
                showHtml += showRowFooter;
                header = false;
            }
                
            showHtml += "<h3 class='text-white'>"+currChar+"</h3>";
            position = 0;
        }
		if(position%showsPerRow == 0)
		{
			showHtml += showRowHeader;
            header = true;
		}
        
		showHtml += showHeader;
		showHtml += showCard[i];
		showHtml += showFooter;
		if(position%showsPerRow == showsPerRow-1)
		{
			showHtml += showRowFooter;
            header = false;
		}
		position++;		
	}
	
	return showHtml;
}

function NumColumCalc(showsPerRow)
{
	return Math.round(12/showsPerRow);
}


