<?php
require_once("./includes/validation.php");
$title="Books";
include("./includes/header.php");
?>
<div id="indiv">
<img id="ba" src="./includes/img/ba.png">

<p class="success" ><?php if(isset($_SESSION["message"])){
echo $_SESSION["message"];} ?></p>	
</div>
<?php
$cat_exist="";
if(!isset($_GET['filter'])){
	redirect("index.php?filter=asc");
}
		if(isset($_GET['filter'])&&($_GET['filter']=="desc")){
		$filter="ASC";
		 echo "<a class=\"filter\" href=\"index.php?filter=asc\">Asc</a>"; 
		}elseif(isset($_GET['filter'])&&($_GET['filter']=="asc")){
		 	echo "<a class=\"filter\" href=\"index.php?filter=desc\">Desc</a>";
			$filter="DESC";
		}else{
		echo "<a class=\"filter\" href=\"index.php?filter=asc\">Asc</a>"; 
		$filter="ASC";
		$_GET['filter']="asc";
		}
		

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
	$ql="SELECT COUNT(book_title) as cnt FROM books as b LEFT JOIN books_authors as ba ON b.book_id=ba.book_id
 LEFT JOIN authors as a ON ba.author_id=a.author_id";
 if(isset($_POST['search'])){
		$p=$_POST['search'];		
		$p=validate($p);
 	$ql.=" WHERE b.book_title LIKE '{$p}%' OR a.author_name LIKE '{$p}%'";
 }
 $ql.=" ORDER BY book_title {$filter}";
 $h = mysqli_query($connect,$ql);
		$cnt_h=$h->fetch_assoc();
		$cnt=$cnt_h['cnt'];
		 $page_size = 15;
		 $pages = ceil($cnt / $page_size);
		 $page = (int)$_GET['page'];
		 if($page < 1 || $page > $cnt) $page = 1;
		 $p_from = ($page-1) * $page_size;
		 $p_to = $page_size;
$asc=$filter;
$q="SELECT * FROM books as b LEFT JOIN books_authors as ba ON b.book_id=ba.book_id
 LEFT JOIN authors as a ON ba.author_id=a.author_id";
 if(isset($_POST['search'])){
		$p=$_POST['search'];		
		$p=validate($p);
 	$q.=" WHERE b.book_title LIKE '{$p}%' OR a.author_name LIKE '{$p}%'";
 }
 $q.=" ORDER BY book_title {$filter} LIMIT $p_from, $p_to";

$res=mysqli_query($connect,$q);
$results=array();
while($row=mysqli_fetch_assoc($res)){
$results[$row['book_id']]['book_title']=$row['book_title'];
$results[$row['book_id']]['authors'][$row['author_id']]=$row['author_name'];
} 
	echo "<table>";?>
		<trclass="title"><td class="titletd" colspan="2">Page: <?=$page?></td></tr>
	<?php $count=0;
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
	echo "<tr><td colspan=\"2\"><span class=\"pages\">";
	for($i=1;$pages>=$i;$i++){
		echo "<a href=\"index.php?filter=".$_GET['filter']."&page=$i\">".$i."</a>";
	}
	echo "</span></td></tr>";
echo "</table>";
?>

</div>
</div>
</body>
</html>