<?php
ob_start();
session_start();
function redirect($page){
	header("Location: ".$page);
	exit;
}
mb_internal_encoding('UTF-8');
function validate($text){
	$connect=mysqli_connect("localhost","whitefinity","Righthand4P1","books");
	$text=htmlentities(trim($text));
	$result=mysqli_real_escape_string($connect,$text);
	return $result;
}
function has_max_length($value, $max) {
	return mb_strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	foreach($fields_with_max_lengths as $field => $max) {
		$value = validate($_POST[$field]);
	  if (!has_max_length($value, $max)) {
	    $errors[$field] = ucfirst($field) . " is too long";
	  }
	}
}

function has_min_length($value,$min) {	
	return mb_strlen($value)>=$min;
}

function validate_min_lengths($fields_with_min_lengths) {
	global $errors;	
	foreach($fields_with_min_lengths as $field => $min) {
		$value = validate($_POST[$field]);
	  if (!has_min_length($value, $min)) {
	   $errors[$field] = ucfirst($field) . " must be minimum 3 symbols";
		 
	  }
	}
}
function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<span class=\"error\">";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
		    $output .=	htmlentities($error);
		    $output.="</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</span>";
		}
		return $output;
	}
function validate_existence($row,$connect){
	global $errors;
	$sql="SELECT author_name FROM authors WHERE author_name='{$row}'";
	$result=mysqli_query($connect,$sql);
	$result = $result->num_rows;
	if($result){
		$errors[$row]="{$row} already exist!";
	}
}
function validate_existences($row,$connect){
	global $errors;	
	$sql="SELECT author_id FROM authors WHERE author_id={$row}";
	$result=mysqli_query($connect,$sql);
	$result = $result->num_rows;
	if(!$result){
		$errors[$row]="{$row} does not exist";
	}
}

function validate_title($row,$connect){
	global $errors;
	$row=validate($row);
	$sql="SELECT book_title FROM books WHERE book_title LIKE '{$row}%'";
	$result=mysqli_query($connect,$sql);	
	$result = $result->num_rows;
	if(!$result){
		$_SESSION['search1']="{$row} does not exist";
		unset($_SESSION['search']);
	}else{
		$_SESSION['search']=$row;
	}
}
function has_presence($value) {
	return isset($value) && $value !== "";
}

function validate_presences($required_fields) {
  global $errors;
  foreach($required_fields as $field) {
    $value = trim($_POST[$field]);
  	if (!has_presence($value)) {
  	 $errors[$field] = ucfirst($field) . " can't be blank";
  	}
  }
}
function submit_validation($connect){
	global $result;
	if(isset($_POST['submit'])){
	$user=mysqli_real_escape_string($connect,trim($_POST['username']));
	$pass=mysqli_real_escape_string($connect,trim($_POST['password']));

$result=mysqli_query($connect, "SELECT * FROM users 
WHERE username='{$user}' AND password='{$pass}'");
$result=$result->fetch_assoc();
if($result){
 $_SESSION['message']=$result['username']." logged in successfully!";
 $_SESSION['isLogged']=true;
 $_SESSION['username']=$result['username'];		
 $_SESSION['user_id']=$result['user_id'];	 
 if($result['username']=="admin"){
$_SESSION['username']=="admin";
 }
redirect("index.php");
}else{
 $_SESSION['message']="<p class=\"error\">wrong username or password</p>";
}}
}

function print_err($errors) {
	foreach($errors as $err) {
		print $err."<br>";
	}
}

?>