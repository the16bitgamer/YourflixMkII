function BuildNavBar(baseUrl)
{
    var nav = "<table style=\"width:100%\" class='bg-dark'>";
    nav += GenerateNav(baseUrl, true);
    nav += "</table>";    
    return nav;
}

function BuildVideoNavBar(baseUrl, episodeName, currShow, nextEpisode, prevEpisode)
{
    var nav = "<table style=\"width:100%\" class='bg-dark'>";
    nav += GenerateNav(baseUrl, false);
    nav += GenerateShowBar(baseUrl, episodeName, currShow, nextEpisode, prevEpisode);
    nav += "</table>";
    
    return nav;
}

function GenerateShowBar(baseUrl, episodeName, currShow, nextEpisode, prevEpisode)
{
    var nav = "<tr>";
    nav += "<th style=\"text-align: left; width:10%;\">";
    if(prevEpisode != "" || nextEpisode != "")
    {
        if(prevEpisode != "")
        {
            nav += "<button type=\"button\" class=\"btn btn-primary\" onclick=\"OpenLink('"+baseUrl+"watch/?video="+prevEpisode+"')\">";
            nav += "<img src=\""+baseUrl+"/img/Left%20Arrow.png\" style=\"height:2em;\"/>";
        }
        else
        {
            nav += "<button type=\"button\" class=\"btn btn-primary\" onclick=\"ReturnShowPage()\">";
            nav += "<img src=\""+baseUrl+"/img/Left%20Arrow.png\" style=\"height:2em;\"/>";
        }
        nav += "</button>";
    }
    nav += "</th>";
    nav += "<th style=\"text-align: center; margin-bottom:0px; width: 80%;\">";
    nav += "<p class=\"text-white\" style=\"font-size:2vw; margin-bottom:0px;\">"+episodeName+"</p>"
    nav += "</th>";
    nav += "<th style=\"text-align: right; width:10%;\">";
    if(prevEpisode != "" || nextEpisode != "")
    {
        if(nextEpisode != "")
        {
            nav += "<button type=\"button\" class=\"btn btn-primary\" onclick=\"OpenLink('"+baseUrl+"watch/?video="+nextEpisode+"')\">";
            nav += "<img src=\""+baseUrl+"img/Right%20Arrow.png\" style=\"height:2em;\"/>";
        }
        else
        {
            nav += "<button type=\"button\" class=\"btn btn-primary\" onclick=\"ReturnShowPage()\">";
            nav += "<img src=\""+baseUrl+"img/Right%20Arrow.png\" style=\"height:2em;\"/>";
        }
        nav += "</button>";
    }
        nav += "</th>";
    nav += "</tr>";
    
    return nav;
}

function GenerateNav(baseUrl, browse)
{
    var nav = "<tr style=\"height: 4em;\">";
    nav += "<th style=\"width:1%;\">";
    nav += "<a href=\""+baseUrl+"browse/\"> <img id=\"Yourflix\" style=\"height: 3em; padding-right: 0.25em;\" src=\""+baseUrl+"img/YourFlix 1080p.png\"/> </a>";
    nav += "</th>";
    nav += "<th style=\"width:99%;\" >";
    if(browse)
    {
        nav += "<a style=\"font-size: 1.5em; padding-left: 0.25em;\" class=\"text-white border-left border-white\" href=\""+baseUrl+"?force=true\">";
        nav += "Force Update";
        nav += "</a>";
    }
    nav += "</th>";
    nav += "</tr>";
    
    return nav;
}

function OpenLink(homeUrl)
{
    window.location.href = homeUrl;
}