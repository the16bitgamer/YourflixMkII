function BuildNavBar(baseUrl)
{
    var nav = "<table style=\"width:100%\" class='bg-dark'>";
    nav += GenerateNav(baseUrl);
    nav += "</table>";
    
    return nav;
}

function BuildVideoNavBar(baseUrl, episodeName, currShow, nextEpisode, prevEpisode)
{
    var nav = "<table style=\"width:100%\" class='bg-dark'>";
    nav += GenerateNav(baseUrl);
    nav += GenerateShowBar(baseUrl, episodeName, currShow, nextEpisode, prevEpisode);
    nav += "</table>";
    
    return nav;
}

function GenerateShowBar(baseUrl, episodeName, currShow, nextEpisode, prevEpisode)
{
    var nav = "<tr>";
    if(prevEpisode != "" || nextEpisode != "")
    {
        nav += "<th style=\"float: left;\">";
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
        nav += "</th>";
    }
    nav += "<th style=\"text-align: center; margin-bottom:0px;\">";
    nav += "<p class=\"text-white\" style=\"font-size:2vw; margin-bottom:0px;\">"+episodeName+"</p>"
    nav += "</th>";
    if(prevEpisode != "" || nextEpisode != "")
    {
        nav += "<th style=\"float: right;\">";
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
        nav += "</th>";
    }
    nav += "</tr>";
    
    return nav;
}

function GenerateNav(baseUrl)
{
    var nav = "<tr>";
    nav += "<th style=\"float: left;\">";
    nav += "<a href=\""+baseUrl+"browse/\"> <img id=\"Yourflix\" style=\"width:4em;\" src=\""+baseUrl+"img/YourFlix 1080p.png\"/> </a>";
    nav += "</th>";
    nav += "</tr>";
    
    return nav;
}

function OpenLink(homeUrl)
{
    window.location.href = homeUrl;
}