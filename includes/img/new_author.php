<?php
require_once("./includes/validation.php");
$title="new author";
include("./includes/header.php");  ?>
<div id="indiv">
			<img id="ba" src="./includes/img/ba.png">
			<span id="pic"></span>
</div>
<form id="newa" method="post">
<input type="text" name="author">
<input type="submit" value="Add author"> 
</form>
<?php
	$errors=array();
	if(isset($_POST['search'])){
			
			redirect("index.php");
		}
	if(isset($_POST['author']) && ($_POST['author']!="")){
	
	$author=validate($_POST['author']);
	validate_existence($author,$connect);
	validate_min_lengths(array('author'=>3));
	validate_max_lengths(array('author'=>20));
	if($errors){
		$res=form_errors($errors);
		//echo $res;
	}else{
		$sql="INSERT INTO authors (author_name) VALUES ('$author')";
		$result=mysqli_query($connect,$sql);
	}
}
$sql="SELECT * FROM authors";
$result=mysqli_query($connect,$sql);
echo "<table id=\"tablena\"><tr><td id=\"author_td\">Authors</td></tr>";
$count=1;
while($row=mysqli_fetch_assoc($result)){
	if($count%2!==0){
		echo "<tr class=\"trcolor\">";
		}else{
		echo	"<tr>";
			}
		$count++;
echo"<td class=\"name\"><a href=\"authors_books.php?aut={$row['author_id']}\">".$row['author_name']."</a></td></tr>";
}
echo"</table>";?>
<p class="errorspan"><?php print_err($errors)?></p>
<?php
if(count($errors)){
echo "<script type=\"text/javascript\">	
$('#ba').fadeOut().delay(4500).fadeIn();
$('.errorspan').fadeIn().delay(4000).fadeOut();
</script>";
}
?>
</body>
</html>