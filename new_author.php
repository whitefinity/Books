<?php
require_once("./includes/validation.php");
include 'includes/config.php';
$title="new author";
include("./includes/header.php");  ?>

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
	if(!$errors){
		$sql="INSERT INTO authors (author_name) VALUES ('$author')";
		$result=mysqli_query($connect,$sql);
		$_SESSION["message"]="You have added a new author!";
		redirect('new_author.php');
	}
}
?>
<img id="ba" src="./includes/img/adda.png">
<?php
if(count($errors)){?>
	<p class="errorspan" >
<?php print_err($errors)?></p>	<?php
echo "<script type=\"text/javascript\">	
 $('#ba').fadeOut();
	$('.errorspan').delay(4000).fadeOut();
    $('#ba').delay(4500).fadeIn();
</script>";
}?>
<p class="success" ><?php
 if(isset($_SESSION["message"])){
echo $_SESSION["message"];
unset($_SESSION["message"]); ?></p>	
<script  language="javascript" >
    $('#ba').fadeOut();
	$('.success').delay(4000).fadeOut();
    $('#ba').delay(4500).fadeIn();
	</script>
	<?php }?>
<form id="newa" method="post">
<input type="text" name="author">
<input type="submit" value="Add author"> 
</form><?php
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
echo"</table>";
include 'includes/footer.php';