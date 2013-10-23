<?php
require_once("./includes/validation.php");
$title="New Books";
include("./includes/header.php");  
$errors = null;
$author=array();
if(isset($_POST['book']) && isset($_POST['authors']) && $_POST['book']!=""){
	foreach($_POST['authors'] as $value){
		$author[]=validate($value);
	}

	foreach($author as $v){
	validate_existences($v,$connect);
	}
	$book=validate($_POST['book']);
	validate_existences($v,$connect);
	validate_min_lengths(array('book'=>3));
	validate_max_lengths(array('book'=>50));
	if(isset($errors)){
		$res=form_errors($errors);
		}else{
		$errors = array();
		$sql="INSERT INTO books (book_title) VALUES ('{$book}')";		
		$result=mysqli_query($connect,$sql);
		if(!$result){
			//$errors[] = "Database failed";
			redirect('error.php');
		}
		$id=mysqli_insert_id($connect);
		foreach($author as $v){
		$sql="INSERT INTO books_authors (book_id,author_id) VALUES ({$id},{$v})";	
		$result=mysqli_query($connect,$sql);
		if(!$result){
			redirect('error.php');
			}
		}
		$_SESSION['message']="Book added successfully!";
		redirect('index.php');
	}
}				


$sql="SELECT * FROM authors";
$result=mysqli_query($connect,$sql) or print mysqli_error();
$authors = array();
while($row = mysqli_fetch_assoc($result)) {
	$authors[] = $row;
}
?>



<div id="indiv" style="" >
<img id="ba" src="./includes/img/ba.png">
<?php 
if(count($errors)) {?>
	<p class="error" ><?php print_err($errors); ?></p>	
<?php } ?>
</div>


<?php if(count($errors)) { ?>
	<script  language="javascript" >
    $('#ba').fadeOut();
	$('.error').delay(4000).fadeOut();
    $('#ba').delay(4000).fadeIn();
	</script>
	<?php } ?>

</div>
</div>
<form id="newb" autocomplete="off" method="post">
	<label for="book">Book name: 
<input type="text" name="book">
</label>
<br>
<label for="authors">Choose an author/s:
<select name="authors[]" multiple required>	 
<?php foreach($authors as $auth){ ?>
	<option value="<?=@$auth['author_id'];?>"><?=@$auth['author_name'];?></option>	
<?php } ?>
</select></label>
<input type="submit" value="Create"> 
</form></div>
</body>
</html>