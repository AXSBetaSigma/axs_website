<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma</title>
		<?php include('imports.php') ?>
	</head>
	<body>
		<main>
			<?php include('header.php'); ?>
			<p id="home-page-text">
				Welcome to the website of the Beta Sigma chapter of the Alpha Chi Sigma professional co-ed chemistry fraternity, located at the Rochester Institute of Technology in Rochester, NY.
			</p>
			<hr>
			<figure class="botw">
			</figure>
			<script type="text/javascript" src='js/brother_of_the_week.js'></script>
			<script type="text/javascript">
				load_botw_xml(draw_botw);
			</script>
			<hr>
			<figure id="bros">
				<!--
				<div id="bros-pic-box">
					<img src="images/brodayspring2018.png" id="bros-pic">
				</div>
				<figcaption>Beta Sigma as of Spring 2018 (Along with some Brothers from Tau chapter). From top-left: Dan Verrico, Peyton Kunselman, Jared Ponzetti, Nathan Johnson, Joe Discua, Matthew Bonney, Eliot Patnode, Hannah Sheldon, Tulio Geraci, Dennis Bogdan, Jordan Dejewski, Kevin Hernandez, Alex North, Sean Su, Hannah Thompson, Aubrey Holand, Dan Saviola, Dave Kozlowski, Alexis Slenz, Trent Mochel, Hira Abid, Brian Zeberl, Elizabeth (&#120591;), Cynthia (&#120591;), Dr. Jeremy Cody, Alexis LaSalle, Joe Hunt, Andrew (&#120591), Sam Burger, Will Charbonneau, Luke Lanza. Not picured Josh Evans.</figcaption>
				-->
				<div id="bros-pic-box">
					<img id="bros-pic">
				</div>
				<figcaption>
				<script type="text/javascript">
					load_image('18fallbroday_grouppic', function(cover_pic) {
						$('#bros-pic').attr('src', cover_pic.src);
						$('#bros figcaption').html(cover_pic.caption);						
					});
				</script>
			</figure>
			<fieldset class="container" id="events-small">
				<legend>Upcoming Events</legend>
				<iframe src="https://calendar.google.com/calendar/embed?src=dvn7q7lc6ibgngq1phe1vmtlt0%40group.calendar.google.com&ctz=America%2FNew_York" style="border: 0" frameborder="0" scrolling="no" id="calendar"></iframe>
			</fieldset>
			<?php include('footer.php'); ?> 
		</main>
	</body>
</html>