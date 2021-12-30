<?php 
	
	#Add news
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_news') {
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php
        if($_POST['archived']){
            $query  = "INSERT INTO news (title, description, subtitle, archived)";
            $query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['subtitle'], ENT_QUOTES) . "', " . $_POST['archived'] . ")";
        }
        else {
            $query  = "INSERT INTO news (title, description, subtitle, archived)";
            $query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['subtitle'], ENT_QUOTES) . "', false)";
        }
        $result = @mysqli_query($MySQL, $query);
		$ID = mysqli_insert_id($MySQL);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
			
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "INSERT INTO pictures (newsId, picture) VALUES (" . $ID . ", '". $_picture . "')";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }
			
		$_SESSION['message'] .= "<p>You successfully added news!</p>";
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	
	# Update news
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_news') {
        if($_POST["archived"]){
            $query  = "UPDATE news SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', description='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', subtitle='" . htmlspecialchars($_POST['subtitle'], ENT_QUOTES) . "', archived=true";
            $query .= " WHERE id=" . (int)$_GET['edit'];
            $query .= " LIMIT 1";
        }
        else {
            $query  = "UPDATE news SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', description='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', subtitle='" . htmlspecialchars($_POST['subtitle'], ENT_QUOTES) . "', archived=false";
            $query .= " WHERE id=" . (int)$_GET['edit'];
            $query .= " LIMIT 1";
        }
        $result = @mysqli_query($MySQL, $query);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
            
			$_picture = (int)$_POST['edit'] . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "INSERT INTO pictures (newsId, picture) VALUES (" . (int)$_POST['edit'] . ", '". $_picture . "')";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>You successfully added picture.</p>';
			}
        }
		
		$_SESSION['message'] = '<p>You successfully changed news!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End update news
	
	# Delete news
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
		
		# Delete picture
        $query  = "SELECT picture FROM news";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("news/".$row['picture']); 
		
		# Delete news
		$query  = "DELETE FROM news";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>You successfully deleted news!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End delete news
	
	
	#Show news info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY date_created DESC";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>News overview</h2>
		<div class="news">
			<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
			<h2>' . $row['title'] . '</h2>
			' . $row['description'] . '
			<time datetime="' . $row['date_created'] . '">' . $row['date_created'] . '</time>
			<hr>
		</div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
	}
	
	#Add news 
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<h2>Add news</h2>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
            <div class="col-md-5">
			<input class="form-control" type="hidden" id="_action_" name="_action_" value="add_news">
			
			<label for="title">Title *</label>
			<input class="form-control" type="text" id="title" name="title" placeholder="News title.." required>
            <label for="title">Subtitle *</label>
			<input class="form-control" type="text" id="subtitle" name="subtitle" placeholder="News subtitle.." required>
			<label for="description">Description *</label>
			<textarea rows="10" cols="30" class="form-control" id="description" name="description" placeholder="News description.." required></textarea>
				
			<label class="form-label" for="picture">Banner picture * <small>(only one for banner)</small></label><br/>
			<input type="file" id="picture" name="picture" required>

            <input type="checkbox" name="archived" value="true">
            <label class="form-check-label" for="flexCheckChecked">
                Archive?
            </label>
			<hr>
			<input class="btn btn-outline-success" type="submit" value="Submit">
            </div>
            </div>
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
	}
	#Edit news
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);

		print '
		<h2>Edit news</h2>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
            <div class="col-md-5">
			<input class="form-control" type="hidden" id="_action_" name="_action_" value="edit_news">
			
            <input type="hidden" value="' . $row['id'] . '">
			<label for="title">Title *</label>
			<input class="form-control" value="' . $row['title'] . '" type="text" id="title" name="title" placeholder="News title.." required>
            <label for="title">Subtitle *</label>
			<input class="form-control" type="text" value="' . $row['subtitle'] . '" id="subtitle" name="subtitle" placeholder="News subtitle.." required>
			<label for="description">Description *</label>
			<textarea rows="10" cols="30" class="form-control" id="description" name="description" placeholder="News description.." required>' . $row['description'] . '</textarea>

            <input type="checkbox" name="archived" value="true">
            <label class="form-check-label" for="flexCheckChecked">
                Archive?
            </label>
			<hr>
			<input class="btn btn-outline-success" type="submit" value="Submit">
            </div>
            </div>
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
	}
	else {
		print '
        <div class="row">
            <div class="col-md-6">
                <h2>News</h2>
            </div> 
            <div class="col-md-6 text-right">
                <a class="btn btn-outline-info" href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Add news</a>
            </div>
        </div>
		<div id="news">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th>Title</th>
						<th style="width: 35%">Description</th>
						<th>Date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM news";
				$query .= " ORDER BY date_created DESC";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td>' . $row['title'] . '</td>
						<td>';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td>' . $row['date_created'] . '</td>
                        <td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '">Info</a>
						<a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '">Uredi</a>';
						if($_SESSION["user"]["role"] == 3){
						print '<a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '">Obriši</a></td>';
						}
						print '
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>