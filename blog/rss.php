<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; 
require('db-config.php'); 

	function timestamp( $date ){
		$date = new DateTime($date);
		return $date->format('r');
	}

?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>
	<title>My PHP Bloggy</title>
	<link>http://localhost/ferran/blog/</link>
	<description>a blog for php practice</description>
	
	<?php 
	//get up to 10 published posts, newest first
	$query = "SELECT posts.title, posts.post_id, posts.body, posts.date, users.email, users.username
			  FROM posts, users
			  WHERE posts.user_id = users.user_id
			  AND posts.is_published = 1
			  ORDER BY date DESC
			  LIMIT 10";
	$result = $db->query($query);
	
	if ( ! $result) {
		echo $db->error;
	}

	if ( $result->num_rows >= 1 ) {
		while( $row = $result->fetch_assoc() ){
	?>
	<item>
		<title><?php echo $row['title']; ?></title>
		<link>http://localhost/ferran/blog/single.php?post_id=<?php echo $row['post_id']; ?></link>
		<guid>http://localhost/ferran/blog/single.php?post_id=<?php echo $row['post_id']; ?></guid>
		<description><![CDATA[<?php echo $row['body']; ?>]]></description>
		<author><?php echo $row['email']; ?> (<?php echo $row['username']; ?>)</author>
		<pubDate><?php echo timestamp($row['date']); ?></pubDate>
	</item>
	<?php 
			}//end while
		}//end if 
	?>

<atom:link href="http://localhost/ferran/blog/rss.php" rel="self" type="application/rss+xml" />
</channel>
</rss>