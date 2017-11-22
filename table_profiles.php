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
				echo "<td>".htmlentities($profile['first_name'])." ".htmlentities($profile['last_name'])."</td>";
				echo "<td>".htmlentities($profile['headline'])."</td>";
				echo '<td>';
					if (isset($_SESSION['user_id'])) {
						echo '<a href="/">Edit</a> / <a href="/">Delete</a>';
					}
				echo "</td>";
				echo "</tr>";
			}
		?>
	</tbody>
</table>
