<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$title;?></title>
	<link href="./includes/style.css" rel="stylesheet" />
	<meta charset="UTF-8"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>

<body>
	<div class="wrap">
		<div class="navi">
			<div class="navi-item left"><a href="index.php">Books</a></div>			
			<div class="navi-item left"><a href="new_book.php">Add Book</a></div>			
			<div class="navi-item left"><a href="new_author.php">Add Author</a></div>			
			<div class="logo"></div>
			<?php 		
		
		if(isset($_SESSION['isLogged']))
			{
				$u=$_SESSION['username'];			
				echo "<div class=\"navi-item2 right\"><a href=\"logout.php\">{$u}, Log out</a></div>";	
				}
				else
				{
					if(!($title=="Sign In"))
					{					
					echo "<div class=\"navi-item2 right\"><a href=\"signin.php\">Sign in</a></div>";	
					}
			}?>
					
					
				
			<form id="search" method="post" action="index.php?filter=asc" role="form">
			<input type="submit" value="Search"/>
			<input type="text" name="search" >			
			</form>
			
		</div>
		
