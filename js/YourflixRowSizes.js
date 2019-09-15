function GetNumColums()
{
	var width = window.innerWidth;
	if(width > 2160)
	{
		return 6;
	}
	else if(width > 1200)
	{
		return 4;
	}
	else if(width > 992)
	{
		return 3;
	}
	else if(width > 768)
	{
		return 2;
	}
	else
	{
		return 1;
	}
}