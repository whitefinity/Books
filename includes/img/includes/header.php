<?php
$connect=mysqli_connect("localhost","whitefinity","Righthand4P1","books");
if(!$connect){
	echo "Database failed";
}?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$title;?></title>
	<link href="./includes/style.css" rel="stylesheet" />
	<meta charset="UTF-8"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body background="./includes/img/back.png">

	<div id="outer">
	<div id="nav">
		
		<?php 		
		
		if(isset($_SESSION['isLogged'])){
			$u=$_SESSION['username'];			
			echo "<a class=\"nba\" href=\"logout.php\">{$u}, Log Out</a>";
		}else{
			if(!($title=="Sign In")){
			echo "<a class=\"nba\" href=\"signin.php\">Sign In</a>";
		}}
	
		if(!($title=="Sign In")){		
		if($title==("Books") || ("New Books")){
		echo "<a class=\"naut\" href=\"new_author.php\">Add author</a>";}?>
		<form id="search" method="post" action="index.php?filter=asc" role="form">
		<input type="submit" value="Search"/>
		<input type="text" name="search" >	
		</form>
		<a class="na" href="index.php?filter=asc">Books</a>
		<a class="nb" href="new_book.php">Add book</a>
		<?php } ?>