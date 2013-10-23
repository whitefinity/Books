<?php
include("./includes/validation.php");
$title="Sign In";
include("./includes/header.php");
?>
<a class="sign" href="registry.php">Registry</a>
<div id="indiv" style="margin-top: 1px;">
<?php
submit_validation($connect);
if(!isset($_SESSION['message'])){
	$message="";
}else{
	$message=$_SESSION['message'];
}
echo $message."<br>"; 
include("./includes/form.php"); ?>