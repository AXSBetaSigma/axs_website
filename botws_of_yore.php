<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma</title>
		<?php include('imports.php') ?>
	</head>
	<body>
		<main>
			<?php include('header.php'); ?>
			<div id=top-container>
				<script type="text/javascript" src='js/brother_of_the_week.js'></script>
				<script type="text/javascript">
					load_botw_xml(function(){
						var d = new Date();
						do {
							$('#top-container').append('<figure class="botw" name="dateof' + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + '"></figure>');
							draw_botw(d);
							d.setDate(d.getDate() - 7);
							$('#top-container').append($('<hr>'));
						} while (d.getTime() > botws[botws.length - 1].week_of.getTime());
					});
				</script>
			</div>
			<?php include('footer.php'); ?> 
		</main>
	</body>
</html>