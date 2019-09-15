<?php

	$url = $_SERVER['SERVER_NAME'];

	$buildNavBar = AddLogo();
	//$buildNavBar .= AddNavItems();
	//$buildNavBar .= AddRightPannel();
	
	echo $buildNavBar;

	function AddLogo()
	{
		$logo = "<a class='navbar-brand' href='#'>";
		$logo .= "<img src='".$url."/img/YourFlix 1080p.png' style='width:3em'>";
		$logo .= "</a>";
		return $logo;
	}

	function AddNavItems()
	{
		$items = "<ul class='navbar-nav mr-auto'>";
		
		$items .= "<li class='nav-item'>";
		$items .= "<a class='nav-link' href='#'>Home</a>";
		$items .= "</li>";
		
		$items .= "<li class='nav-item'>";
		$items .= "<a class='nav-link' href='#'>Movie</a>";
		$items .= "</li>";
		
		$items .= "<li class='nav-item'>";
		$items .= "<a class='nav-link' href='#'>TV Show</a>";
		$items .= "</li>";
		
		//TODO Add User Profiles and add Functionality to My Lists
		//$items .= "<li class='nav-item'>";
		//$items .= "<a class='nav-link' href='#'>My Lists</a>";
		//$items .= "</li>";
		
		$items .= "</ul>";
		
		return $items;
	}

	function AddRightPannel()
	{
		$rightSizePannel = "<ul class='navbar-nav ml-auto'>";
		$rightSizePannel .= AddNavUsers();
		$rightSizePannel .= AddNavSearch();
		$rightSizePannel .= "</ul>";
		
		return $rightSizePannel;
	}

	function AddNavSearch()
	{
		$searchBar = "<li class='nav-item ml-auto pl-3'>";
		$searchBar .= "<form action='#'>";
		$searchBar .= "<div class='input-group'>";
		$searchBar .= "<input class='form-control' type='text' placeholder='Search'/>";
		$searchBar .= "<div class='input-group-append'>";
		$searchBar .= "<button class='btn bg-yourflix' type='submit'><img src='".$url."/img/Search.png' style='width:1.25em;'></button>";
		$searchBar .= "</div>";
		$searchBar .= "</div>";
		$searchBar .= "</form>";
		$searchBar .= "</li>";
		
		return $searchBar;
	}

	function AddNavUsers()
	{
		$userDropdown = "<li class='nav-item ml-auto'>";
		$userDropdown .= "<div class='dropdown'>";
		$userDropdown .= "<button class='btn btn-dark dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
		$userDropdown .= "<img src='".$url."/img/NewUser.png' style='width:1.25em;'>";
		$userDropdown .= "</button>";
		$userDropdown .= "<div class='dropdown-menu dropdown-menu-right bg-dark' aria-labelledby='dropdownMenuButton'>";
		$userDropdown .= "<a class='dropdown-item bg-dark text-white' href='#'>Profile</a>";
		$userDropdown .= "<a class='dropdown-item bg-dark text-white' href='#'>Change Account</a>";
		$userDropdown .= "</div>";
		$userDropdown .= "</div>";
		$userDropdown .= "</li>";
		return $userDropdown;
	}

?>