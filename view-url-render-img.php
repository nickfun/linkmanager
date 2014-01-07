<h3>IMG Render</h3>

<table class="table table-bordered table-striped">
<?php foreach( $list as $entry ): ?>
	<tr>
		<td>
			<img src="<?= $entry ?>">
		</td>
	</tr>
<?php endforeach; ?>
</table>