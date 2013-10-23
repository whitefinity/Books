<?php
require_once("./includes/validation.php");
$title="Author's books";
include("./includes/header.php");
?>
<div id="indiv">
<img id="ba" src="./includes/img/ba.png">
<span id="pic"></span>
</div>
<?php
if(isset($_GET['aut'])){
$author=validate($_GET['aut']);
validate_existences($author,$connect);
if($errors){
	$_SESSION["message"]="No such author!";
	header("Location: index.php");
	exit;
}	
$q="SELECT book_id,book_title,author_name,authors.`author_id`
FROM `authors` 
JOIN books_authors USING(author_id)
JOIN books USING(book_id)
JOIN books_authors AS bas USING(book_id)
WHERE bas.author_id ={$author}";
$result=mysqli_query($connect,$q);
$e=mysqli_num_rows($result);
if(empty($e)){echo "<p>NO results for this author!</p>";}else{
$results=array();
while($row=mysqli_fetch_assoc($result)){
$results[$row['book_id']]['book_title']=$row['book_title'];
$results[$row['book_id']]['authors'][$row['author_id']]=$row['author_name'];
}
$count=0;
	echo "<table>";
	foreach($results as $key_id=>$v){
		if($count%2!==0){
		echo "<tr class=\"trcolor\">";
		}else{
		echo	"<tr>";
			}
		$count++;
		echo "<td class=\"title\"><span class=\"cover\"><a href=\"books.php?book={$key_id}\">".$v['book_title']."</a></span>";		
		$sql ="SELECT COUNT(book_id) as cnt FROM comments WHERE book_id={$key_id}";		
		$num=mysqli_query($connect,$sql);
		$cnt=mysqli_fetch_assoc($num);		
		echo " <span class=\"cnt\">(".$cnt['cnt'].")</span>";
		echo "</td><td class=\"name\">";
		$arr=array();
	
		foreach($v['authors'] as $key=>$vv){
				$arr[]="<a href=\"authors_books.php?aut=".$key."\">".$vv."</a>";		
		}
		echo implode(', ', $arr);
		echo "</td></tr>";
	}
	}}?>
</body>
</html>