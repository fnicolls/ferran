<?php 
//header has the authentication, db connection and doctypes
require ('admin-header.php'); 

//delete parser
if ($_GET['action'] == 'delete'){
	//which comment deleting
	$comment_id = filter_var($_GET['comment_id'], FILTER_SANITIZE_NUMBER_INT);
	$query_delete = "DELETE FROM comments
					 WHERE comment_id = $comment_id
					 LIMIT 1";
	$result_delete = $db->query($query_delete);
	//feedback
	if( $db->affected_rows == 1 ){
		$feedback = 'comment deleted';
	}
}
?>

<section class="panel important">
	<h2>Manage comments</h2>
	<?php 
	form_feedback($feedback, array());

	$query_comm = "SELECT comments.name, comments.body, comments.comment_id, posts.title
		  	  	   FROM comments, posts
		  	  	   WHERE comments.post_id = posts.post_id
		  	  	   AND posts.user_id = " . USER_ID .
		  	  	   " ORDER BY comments.date DESC";
	$result_comm = $db->query($query_comm);

	if ( ! $result_comm ){
		echo $db->error;
	}
	if( $result_comm->num_rows >= 1 ){

	 ?>
	<table>
		<tr>
			<th>Name</th>
			<th>Comment</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	<?php 
		while( $row_comm = $result_comm->fetch_assoc() ){  ?>
		<tr>
			<td><b><?php echo $row_comm['name']; ?></b>
			<br><?php echo $row_comm['title']; ?></td>
			<td><?php echo substr($row_comm['body'], 0, 50); ?></td>
			<td><a href="admin-edit-comment.php?comment_id=<?php echo $row_comm['comment_id']; ?>"><i class="fa fa-pencil"></i></a></td>
			<td><a href="?action=delete&amp;comment_id=<?php echo $row_comm['comment_id']; ?>" class="warn" onclick="return confirmAction()"><i class="fa fa-trash"></i></a></td>
		</tr>
	<?php }//end while ?>
	</table>
<?php 
	}else{
		echo 'no comments';
	}//end if
?>
</section>

<script>
	
	function confirmAction(){
		var agree = confirm("Are you sure you want to delete? This cannot be undone");
		if(agree){
			return true;
		}else{
			return false;
		}
	}


</script>

<?php include ('admin-footer.php'); ?>