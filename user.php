<?php
require_once("./includes/validation.php");
include 'includes/config.php';
$title="User";
include("./includes/header.php");
?>
<img id="ba" src="./includes/img/uc.png">

<script>$('<p/>',{
    text: '<?=$_SESSION["message"];?>',
    'class': 'foo'
}).appendTo('body').hide();</script>

 
<?php
if(!isset($_GET['user'])){
	redirect("index.php?filter=asc");
	exit;
}
	$user_id=validate($_GET['user']);
	$sql="SELECT user_id FROM users WHERE user_id={$user_id}";
	$result=mysqli_query($connect,$sql);
	$result = $result->num_rows;
	if(!$result){
		redirect("index.php?filter=asc");
	exit;
	}else{
		$h = mysqli_query($connect,"SELECT COUNT(comments) as cnt FROM comments WHERE user_id={$user_id} LIMIT 1");
		$cnt_h=$h->fetch_assoc();
		$cnt=$cnt_h['cnt'];
		 $page_size = 7;
		 $pages = ceil($cnt / $page_size);
		 $page = @(int)$_GET['page'];
		 if($page < 1 || $page > $cnt) $page = 1;
		 $p_from = ($page-1) * $page_size;
		 $p_to = $page_size;
$q="SELECT * FROM users as u LEFT JOIN comments as c USING(user_id) LEFT JOIN books as b USING(book_id) 
LEFT JOIN books_authors USING(book_id) LEFT JOIN authors USING(author_id)";
$q.=" WHERE u.user_id={$user_id} LIMIT $p_from, $p_to";

$res=mysqli_query($connect,$q);
$results=array();
$book="Book: ";
$count=0;
echo "<table >";
while($row=mysqli_fetch_assoc($res)){
	if(!$count>=1){
	echo "<tr class=\"title\"><td class=\"titletd\">All comments for username: 
	<a href=\"user.php?user={$row['user_id']}\">".$row['username']."</a></td></tr><trclass=\"title\"><td class=\"titletd\">
	 Page: ".$page."</td></tr>";
	}
	$count++;
	echo "<tr><td class=\"comfont\">".$row['comments']."</td></tr>";
	echo "<tr class=\"trcolor\"><td class=\"title\">Date: ".$row['date']." ".$book."<a href=\"books.php?book=".$row['book_id']."\">"
	.$row['book_title']."</a></td></tr>";
	}
echo "<tr><td><span class=\"pages\">";
for($i=1;$pages>=$i;$i++){
		echo "<a href=\"user.php?user={$user_id}&page=$i\">".$i."</a>";
	}
	echo "</span></td></tr>";
echo "</table>";

}

include 'includes/footer.php';
