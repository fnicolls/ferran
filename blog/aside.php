<aside>

<?php 
//get the titles of the published posts
$posts = "SELECT title
		  FROM posts
		  WHERE is_published = 1
		  ORDER BY date DESC
		  LIMIT 5";
//run it
$result = $db->query($posts);
//check it
if ( $result->num_rows >=1 ) { ?>
	<section>
		<h4>latest posts</h4>
		<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
			<li><a href="#"><?php echo $row['title']; ?></a></li>
		<?php }//end while
		$result->free(); ?>
		</ul>
	</section>
<?php }//end if ?>
		

<?php 
//get the category names
$cats = "SELECT name
		 FROM categories
		 ORDER BY name ASC";
//run it
$result = $db->query($cats);
//check it
if ( $result->num_rows >=1 ) { ?>		
	<section>
		<h4>categories</h4>
		<ul>
		<?php while ( $row = $result->fetch_assoc() ){ ?>
			<li><a href="#"><?php echo $row['name']; ?></a></li>
		<?php }//end while
		$result->free(); ?>
		</ul>
	</section>
<?php }//end if ?>


<?php 
//get link title and urls
$links = "SELECT title, url
		  FROM links";
//run it
$result = $db->query($links);
//check it
if ( $result->num_rows >=1 ) { ?>
	<section>
		<h4>links</h4>
		<ul>
		<?php while( $row= $result->fetch_assoc() ){ ?>
			<li><a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['title']; ?></a></li>
		<?php }//end while
		$result->free(); ?>
		</ul>
	</section>
<?php }//end if ?>
	

</aside>