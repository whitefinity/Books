<?php
include("./includes/validation.php");
include 'includes/config.php';
$title="Sign In";
include("./includes/header.php");
?>
<a class="sign" href="registry.php">Registry</a>
<?php
submit_validation($connect);?>
<p class="success" ><?php
 if(isset($_SESSION["message"])){
echo $_SESSION["message"];} ?></p>	
<?php
if(isset($_SESSION["message"])) {
	 ?>
	<script  language="javascript" >
    $('#ba').fadeOut();
	$('.success').delay(4000).fadeOut();
    $('#ba').delay(4000).fadeIn();
	</script>
	<?php 
	unset($_SESSION["message"]);
}
include("./includes/form.php"); 
include 'includes/footer.php';