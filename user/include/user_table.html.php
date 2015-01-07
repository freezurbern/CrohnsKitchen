<hr />
<h3>Here are all the users in the database:</h3>
	<table>
		<thead>
			<tr>
				<td>uid</td>
				<td>user</td>
				<td>email</td>
				<td>pass</td>
				<td>Date Registered</td>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($userdata as $curUser): ?>
			<tr>
				<td><?php echo htmlspecialchars($curUser['uid'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['user'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['email'], ENT_QUOTES, 'UTF-8'); ?></td> 
				<td><?php echo htmlspecialchars($curUser['pass'], ENT_QUOTES, 'UTF-8'); ?></td>
				<td><?php echo htmlspecialchars($curUser['date_registered'], ENT_QUOTES, 'UTF-8'); ?></td> 
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>