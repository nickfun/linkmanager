<?php

function getDomain($url) {
	$r = parse_url($url);
	if( $r === false || !isset($r['host']) ) {
		return '???';
	}
	return $r['host'];
}

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
		<h1>Link Saver</h1>
	</div>

	<form method="post" action="LinkSaver.php?a=post_save" role="form" class="form-inline">
		<div class="form-group">
			<label for="url">URL to remember</label>
			<input type="text" class="form-control input-lg" name="url" required>
		</div>
		<button type="submit" class="btn btn-default">Remember</button>
	</form>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th class="index">Index</th>
				<th class="domain">Domain</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($list as $index => $url): ?>
		<tr class="top">
			<td>
				<?= $index ?>
				<button type="button" data-index="<?= $index ?>" class="delete">X</button>
			</td>
			<td><?= getDomain($url) ?></td>
		</tr>
		<tr class="bottom">
			<td colspan="2">
				<a href="<?= $url ?>" target="_new"><?= $url ?></a>
			</td>
			
		</tr>
	<?php endforeach; ?>
		</tbody>
	</table>

	<div id="dialog-confirm-delete">
		<p>This link will be deleted forever. Is that OK?</p>
	</div>

	<script>
	function deleteByIndex(id, cb) {
		$.ajax('LinkSaver.php?a=ajax_delete&index=' + id)
		.done(cb);
	}

	function initDialog() {
		$('#dialog-confirm-delete').dialog({
			modal: true,
			autoOpen: false,
			width: 400,
			height: 200,
			title: 'Delete a link'
		});
	}

	function confirmDelete(id) {
		$('#dialog-confirm-delete').dialog({
			buttons: {
				Ok: function() {
					deleteByIndex(id);
					$(this).dialog('close');
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		})
		$('#dialog-confirm-delete').dialog('open');
	}

	$(document).ready(function() {
		
		initDialog();

		$('button.delete').click(function(e) {
			$button = $(e.target);
			var id = $button.attr('data-index');
			confirmDelete(id);
		});
	});

	var FORMDATA = <?= json_encode($_POST); ?>;
	function populateForms(FORMDATA) {
		_.each(FORMDATA, function(value, key) {
			var r =$('[name=' + key + ']');
			if( r.length == 1 && typeof r.val === 'function' ) {
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