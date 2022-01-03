<?php
	
	if (isset($action) && $action != '') {
		$query  = "SELECT * FROM news INNER JOIN pictures ON news.id = pictures.newsId";
		$query .= " WHERE news.id=" . $_GET['action'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
			print '
      <br />
      <div class="container">
        <h1>
          ' . $row["title"] . '
        </h1>
        <h5>
            ' . $row["subtitle"] . ' 
        </h5>
        <hr />
				<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
        <hr />
        <p>'. $row["description"] . ' </p>
        <hr>
        <a href="index.php?menu=2">Back to News</a>
		  <div>';
	}
	else {
		print '<br><div class="container"><h1>News</h1><hr>';
		$query  = "SELECT * FROM news INNER JOIN pictures ON news.id = pictures.newsId";
    $query .= " WHERE archived=false";
		$query .= " ORDER BY date_created DESC";
		$result = @mysqli_query($MySQL, $query);
		while($row = @mysqli_fetch_array($result)) {
			print '
			<div class="news">';
				if(strlen($row['description']) > 300) {
          echo '<a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '"><img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '"></a>';
          echo '<h2><a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">' . $row['title'] . '</a></h2>';
					echo substr(strip_tags($row['description']), 0, 300).'... <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">More</a>';
				} else {
          echo '<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">';
          echo '<h2>' . $row['title'] . '</h2>';
					echo strip_tags($row['description']);
				}
				print '
				<time datetime="' . $row['date_created'] . '">' . $row['date_created'] . '</time>
				<hr>
			</div>';
		}
    print '</div><br>';
	}
?>