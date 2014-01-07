<?php

?>
<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>
	<link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
	<!--
	<link href="http://bootswatch.com/cyborg/bootstrap.css" rel="stylesheet" type="text/css"></link>
	-->
	<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap.js"></script>
	<meta charset=utf-8 />
	<title>Link Saver</title>
	<style>
	button.delete {
		background-color: red;
		font-family: monospace;
	}
	</style>
</head>
<body>

	<?php include 'view-common-top.php'; ?>

	<div class="page-header">
		<h1>URL Pattern Tool</h1>
	</div>

	<form method="post" action="UrlPattern.php?a=post_submit" role="form" class="form-inline">
		<div class="form-group">
			<label>URL template
			<input type="text" class="form-control input-lg" name="template" required>
			</label>
		</div>
		<div class="form-group">
			<label>Numbering pattern 
			<input type="text" class="form-control input-lg" name="pattern" required>
			</label>
		</div>
		<div class="form-group">
			<label>Length
			<input type="text" class="form-control input-lg" name="length" required>
			</label>
		</div>
		<div class="form-group">
			Render Type:
			<label>
				<input type="radio" name="render" value="links" checked>
				Links
			</label>
			<label>
				<input type="radio" name="render" value="img">
				Display Images
			</label>
		</div>
		<button type="submit" class="btn btn-default">Render</button>
	</form>

	<?php if( isset($RENDER_VIEW) ) { include $RENDER_VIEW; } ?>

	<script>
	var FORMDATA = <?= json_encode($_POST); ?>;
	function populateForms(FORMDATA) {
		_.each(FORMDATA, function(value, key) {
			var r =$('[name=' + key + ']');
			if( r.length == 1 ) {
				r.val( value );
			}
		});
	}
	$(document).ready(function() {
		populateForms(FORMDATA);
	});
	</script>
</body>
</html>