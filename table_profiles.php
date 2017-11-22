<table border="1">
	<thead>
		<tr>
			<th>Name</th>
			<th>Headline</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			while ($profile = $profiles->fetch(PDO::FETCH_ASSOC)) {
				echo "<tr>";
				echo "<td>" . htmlentities($profile['name']) . "</td>";
				echo "<td>" . htmlentities($profile['headline']) . "</td>";
				echo "<td><a href='edit.php?autos_id=".$profile['autos_id']."'>Edit</a> / <a href='delete.php?autos_id=".$profile['autos_id']."'>Delete</a></td>";
				echo "</tr>";
			}
		?>
	</tbody>
</table>
<div><a href="add.php">Add a new entry</a></div>
<div><a href="logout.php">Logout</a></div>
