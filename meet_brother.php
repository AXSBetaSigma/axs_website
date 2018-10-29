<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma - Meet the Brothers</title>
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel='stylesheet' href='css/bootstrap.css' type='text/css'>
		<link rel='stylesheet' href='style.css' type='text/css'>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="https://d3js.org/d3.v4.min.js"></script>
		<script type="text/javascript" src="scripts.js"></script>
	</head>
	<body>
		<main>
			<?php include('header.php'); ?>
			<div id="brothers">
				
			</div>
			<script type="text/javascript">
				bros = []

				function draw_brothers() {
					sel = d3.select("#brothers").selectAll("section").data(bros).enter();
					section = sel.append("section")
						.attr("id", function(x){return x.fn + x.ln;}) // set this object to have a unique ID for easy access. [firstname][lastname] should be unique I think
						.attr("class", "bro");
					section.append("img")
						.attr("class", "bro-portrait")
						.attr("src", function(x){return x.get_portrait_src();});
					section.append("h4")
						.attr("class", "bro-name")
						.html(function(x){return x.fn + " " + x.ln;});
					section.append("br")
					section.append("p")
						.attr("class", "bro-bio")
						.html(function(x){return x.bio;});
					d3.select("#brothers").selectAll("section").each(function(d, i){

					});

				}

				// main script
				var xhttp = new XMLHttpRequest();
				xhttp.overrideMimeType('application/xml');
				xhttp.onreadystatechange = function() {
				    if (this.readyState == 4 && this.status == 200) {
				    	xml = this.responseXML;
				    	filter = function(x){
				    		return true;
				    	}
				        load_brothers(xml, bros, filter);
				        // sort_brothers();
				        draw_brothers();
				    }
				};
				xhttp.open("GET", "brothers.xml", true);
				xhttp.send();
			</script>
			<?php include('footer.php'); ?> 
		</main>
	</body>
</html>