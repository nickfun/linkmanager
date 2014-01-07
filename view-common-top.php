<ul class="nav nav-tabs">
	<li><a href="LinkSaver.php">Link Saver</a></li>
	<li><a href="UrlPattern.php">URL Pattern</a></li>
	<li><a href=".">Index</a></li>
</ul>

<?php if(isset($msg) && $msg != false): ?>
	<div class="alert alert-info">
		<?= $msg ?>
	</div>
<?php endif; ?>