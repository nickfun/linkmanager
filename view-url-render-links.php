<h3>URL Link Render</h3>

<table class="table table-bordered table-striped">
<?php foreach( $list as $entry ): ?>
	<tr>
		<td>
			<a href="<?= $entry ?>"><?= $entry ?></a>
		</td>
	</tr>
<?php endforeach; ?>
</table>