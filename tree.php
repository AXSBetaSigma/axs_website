<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma</title>
		<?php include('imports.php') ?>
	</head>
	<body>
		<main>
			<?php include('header.php'); ?>
			<select multiple id="tree-root-select" onchange=draw_tree></select>
			<svg>
			</svg>
			<script type="text/javascript" src="js/tree.js"></script>
		</main>
	</body>
</html>