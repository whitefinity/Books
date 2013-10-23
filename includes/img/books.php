<?php
require_once("./includes/validation.php");
$title="Book";
include("./includes/header.php");
?>

<div id="indiv">

<script>$('<p/>',{
    text: '<?=$_SESSION["message"];?>',
    'class': 'foo'
}).appendTo('body').hide();</script>
</div>
<?php
if(!isset($_GET['book'])){
	redirect("index.php?filter=asc");
	exit;
}
	$book_id=validate($_GET['book']);
	$sql="SELECT book_id FROM books WHERE book_id={$book_id}";
	$result=mysqli_query($connect,$sql);
	$result = $result->num_rows;
	if(!$result){
		$_SESSION["message"]="There is no such author!";
		redirect("index.php?filter=asc");
	exit;
	}else{
		
$q="SELECT * FROM books as b LEFT JOIN books_authors as ba ON b.book_id=ba.book_id
 LEFT JOIN authors as a ON ba.author_id=a.author_id";
 $q.=" WHERE b.book_id={$book_id}";
$res=mysqli_query($connect,$q);
$results=array();
while($row=mysqli_fetch_assoc($res)){
$results[$row['book_id']]['book_title']=$row['book_title'];
$results[$row['book_id']]['authors'][$row['author_id']]=$row['author_name'];
}
		echo "<div class=\"comment\"><table class=\"comt\">";
		foreach($results as $key_id=>$v){
		echo "<tr><td class=\"title\"><a href=\"books.php?book={$key_id}\">".$v['book_title']."</a></td><td class=\"name\">";
		foreach($v['authors'] as $key=>$vv){
			$arr[]="<a href=\"authors_books.php?aut=".$key."\">".$vv."</a>";		
		}
		echo implode(', ', $arr);
		echo "</td></tr>";	
	}
		echo "</table>";
};
if(isset($_POST['submit'])&&($_POST['comment'])!=""){
	var_dump($_POST['comment']);
	$user_id=validate($_SESSION['user_id']);	
	$comment=validate($_POST['comment']);
	$sql="insert into comments (user_id,book_id,comments,date) ";
	$sql.="VALUES ({$user_id},{$book_id},'{$comment}',NOW())";
	$result_com=mysqli_query($connect,$sql);
	if(mysqli_error($connect)){
	echo mysqli_error($connect);
	}
redirect("books.php?book={$book_id}");
exit;
}
		$h = mysqli_query($connect,"SELECT COUNT(comments) as cnt FROM comments WHERE book_id={$book_id} LIMIT 1");
		$cnt_h=$h->fetch_assoc();
		$cnt=$cnt_h['cnt'];
		 $page_size = 7;
		 $pages = ceil($cnt / $page_size);
		 $page = @(int)$_GET['page'];
		 if($page < 1 || $page > $cnt) $page = 1;
		 $p_from = ($page-1) * $page_size;
		 $p_to = $page_size;


	$sql="SELECT users.username,DATE_FORMAT(comments.date,'%D %M %Y %H:%m:%s') as date,comments.comments,comments.parent_id,
	comments.user_id FROM comments LEFT JOIN users USING(user_id) WHERE 
	comments.book_id={$book_id} ORDER BY date ASC LIMIT $p_from, $p_to";
	$user_com=mysqli_query($connect,$sql);
	if(mysqli_error($connect)){
		echo mysqli_error($connect);
	}

	$get_com=array();
	echo "<table class=\"comt2\"><trclass=\"title\"><td class=\"titletd\">
	 Page: ".$page."</td></tr>";
	while($row=mysqli_fetch_assoc($user_com)){
		echo "<tr><td class=\"name\"><a href=\"user.php?user={$row['user_id']}\">"
		.$row['username']."</a> | ".$row['date']."</td></tr>";
		echo "<tr class=\"trcolor\"><td>".wordwrap(nl2br($row['comments']),180,"<br>",TRUE)."</td></tr>";	
		}
	echo "<tr><td><span class=\"pages\">";
for($i=1;$pages>=$i;$i++){
		echo "<a href=\"books.php?book={$book_id}&page=$i\">".$i."</a>";
	}
	echo "</span></td></tr>";
echo "</table>";
if(isset($_SESSION['isLogged'])){	
echo "<form class=\"com\" method=\"post\" name=\"books\">";
echo "<label for=\"comment\">Add new comment</label><br>";
echo "<textarea name=\"comment\" class=\"come\"></textarea><br>";
echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" /></form>";
}
?>
	</body>
</html>
