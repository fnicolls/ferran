<?php 
//header has the authentication, db connection and doctypes
require ('admin-header.php'); 



?>

  <section class="panel important">
    <h2>Manage Your Posts</h2>

<?php //get all posts written by logged in user, newest first

$query = "SELECT posts.title, posts.is_published, posts.date, posts.post_id, categories.name
		  FROM posts, categories
		  WHERE posts.category_id = categories.category_id
		  AND posts.user_id = " . USER_ID .
		  " ORDER BY date DESC";

$result = $db->query($query);

if( ! $result ){
	echo $db->error;
}
if ( $result->num_rows >=1 ){

?>
    <table>
    	<tr>
    		<th>Title</th>
    		<th>Status</th>
    		<th>Date</th>
    		<th>Category</th>
    	</tr>
  <?php while ( $row = $result->fetch_assoc() ){ ?>  	
    	<tr>
    		<td><a href="admin-edit.php?post_id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a></td>
    		<td><?php echo $row['is_published'] == 1 ? 'Public' : '<b>Draft</b>' ; ?></td>
    		<td><?php echo nice_date($row['date']); ?></td>
    		<td><?php echo $row['name']; ?></td>
    	</tr>
   <?php }//end while ?> 
    </table>
<?php 
}//end if 

?> 
</section>

<?php include ('admin-footer.php'); ?>