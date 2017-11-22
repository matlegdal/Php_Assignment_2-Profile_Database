<div class="container">
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Headline</th>
			<?php if (isset($_SESSION['user_id'])) {
				echo "<th>Action</th>";
			}?>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($profiles as $profile) {
			echo "<tr>";
			echo "<td><a href=view.php?profile_id=".$profile['profile_id'].">".htmlentities($profile['first_name'])." ".htmlentities($profile['last_name'])."</a></td>";
			echo "<td>".htmlentities($profile['headline'])."</td>";
			if (isset($_SESSION['user_id'])) {
				echo '<td>';
				echo '<a href="edit.php?profile_id='.$profile['profile_id'].'">Edit</a> / <a href="delete.php?profile_id='.$profile['profile_id'].'">Delete</a>';
				echo "</td>";
			}
		}
		?>
	</tbody>
</table>
</div>