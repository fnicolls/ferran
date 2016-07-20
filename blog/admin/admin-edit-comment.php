<?php 
//header has the authentication, db connection and doctypes
require ('admin-header.php'); 

//update parser
if ( $_POST['did_save'] ){
	$publish 	= mysqli_real_escape_string( $db, filter_var($_POST['publish'], FILTER_SANITIZE_NUMBER_INT) );

	if( $publish == '' ){
		$publish = 0;
	}

	$valid = true;

	if($valid){
		$comment_id = filter_var($_GET['comment_id'], FILTER_SANITIZE_NUMBER_INT);
		$query = "UPDATE comments
				  SET is_approved = $publish
				  WHERE comment_id = $comment_id";
		$result = $db->query($query);

		if( ! $result ){
			$feedback = $db->error;
		}elseif( $db->affected_rows == 1 ){
			$feedback = 'Comment published';
		}else{
			$feedback = 'No changes made';
		}
	}else{
		$feedback = 'invalid';
	}
}//end parser
?>

<section class="panel important">
	<h2>Edit comment</h2>
<?php 
	form_feedback($feedback, array());

	$query_comm = "SELECT name, body, is_approved
				   FROM comments
				   LIMIT 1";
	$result_comm = $db->query($query_comm);

	if ( ! $result_comm ){
		echo $db->error;
	}
	if ( $result_comm->num_rows == 1 ){
 ?>
	<table>
		<tr>
			<th>Name</th>
			<th>Comment</th>
			<th>Publish</th>
		</tr>
		
	<?php while( $row_comm = $result_comm->fetch_assoc() ){  ?>
		<tr>
			<td><?php echo $row_comm['name']; ?></td>
			<td><?php echo $row_comm['body']; ?></td>
			
			<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
			<td>	
				<input type="checkbox" name="publish" value="<?php echo $row_comm['is_approved']; ?>">
			</td>
			<td>
				<input type="submit" value="save">
				<input type="hidden" name="did_save" value="1">
			</td>
			</form>
		</tr>
	<?php }//end while ?>
	</table>
<?php 
	}else{
		echo 'no comment to show';
	}
?>	

</section>

<?php include ('admin-footer.php'); ?>