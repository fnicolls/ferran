<aside>
	<section class="search">
		<form action="search.php" method="get">
			<input type="search" name="phrase" placeholder="search" value="<?php echo $phrase ?>">
			<input type="submit" value="Search" id="submit">
		</form>

	</section>

	<section>
		<h4>Navigation</h4>
		<ul>
			<li><a href="blog.php">Blog</a></li>
			<li><a href="links.php">Links</a></li>
			<li><a href="authors.php">Authors</a></li>
			<li><a href="rss.php" target="_blank">RSS</a></li>
		</ul>
	</section>


<?php 
//get the titles of the published posts
$posts = "SELECT title, post_id
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
			<li>
			<a href="single.php?post_id=<?php echo $row['post_id'];?>">
			<?php echo $row['title']; ?></a>
			<span>(<?php count_comments( $row['post_id'], 1 ); ?>)</span>
			</li>
		<?php }//end while
		$result->free(); ?>
		</ul>
	</section>
<?php }//end if ?>
		

<?php 
//get the category names and count the posts in those categories
$cats = "SELECT categories.name, COUNT(*) AS postcount
		 FROM categories, posts
		 WHERE categories.category_id = posts.category_id
		 GROUP BY posts.category_id
		 ORDER BY categories.name ASC";
//run it
$result = $db->query($cats);
//check it
if ( $result->num_rows >=1 ) { ?>		
	<section>
		<h4>categories</h4>
		<ul>
		<?php while ( $row = $result->fetch_assoc() ){ ?>
			<li><a href="category.php?post_id=<?php echo $row['name'];?>"><?php echo $row['name']; ?></a> <span>(<?php echo $row['postcount']; ?>)</span></li>
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
		<h4><a href="links.php">links</a></h4>
		<ul>
		<?php while( $row= $result->fetch_assoc() ){ ?>
			<li><a href="<?php echo $row['url']; ?>" target="_blank"><?php echo $row['title']; ?></a></li>
		<?php }//end while
		$result->free(); ?>
		</ul>
	</section>
<?php }//end if ?>
	

</aside>