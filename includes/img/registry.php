<?php
require_once("./includes/validation.php");
$title="Sign Up";
include("./includes/header.php");
?>
<div id="indiv">
<?php
$result="";
		$errors=array();
		$_SESSION['message']="";
		if(isset($_POST['submit'])){
		$user=mysqli_real_escape_string($connect,trim($_POST['username']));
		$pass=mysqli_real_escape_string($connect,trim($_POST['password']));		
		validate_presences($user_pass=array("username","password"));
		if(!$errors){
		validate_min_lengths($min_lengths=array("username"=>3));
		validate_min_lengths($min_lengths=array("password"=>3));
		validate_max_lengths($max_lengths=array("username"=>20));
		validate_max_lengths($max_lengths=array("password"=>20));
		}
$h=mysqli_query($connect, "SELECT username FROM users WHERE username='{$user}'");
$results=$h->fetch_assoc();
if($results['username']){
$errors['username']="username already exist!";
}

	if(!$errors){
	$result=mysqli_query($connect, "INSERT INTO users (username,password) VALUES ('{$user}','{$pass}')");

			}else{
			$_SESSION['errors']=$errors;
				}
			if($result){

		 $_SESSION['message']="success";
		redirect("signin.php");
	}
}
		if(!isset($_SESSION['message'])){
	$message="";
}else{
	$message=$_SESSION['message'];
}
echo $message."<br>"; 
echo form_errors($errors);
include("./includes/form.php"); ?>