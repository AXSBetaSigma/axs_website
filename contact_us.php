<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma - Contact Us</title>
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel='stylesheet' href='css/bootstrap.css' type='text/css'>
		<script type="text/javascript" src='js/bootstrap.js'></script>
		<link rel='stylesheet' href='style.css' type='text/css'>
		<script src="https://d3js.org/d3.v5.min.js"></script>
	</head>
	<body>
		<?php include('header.php'); ?>
		<h3>Contact Us</h3>
		<p>
			Get in touch with one of our four officers!
		</p>
		<svg id='officers-portraits' width='100%' height='800px'>
		</svg>
		<script>

		function coords_to_str(x) {
			return x[0] + "," + x[1];
		}

		Array.prototype.roll = function(x){
			for (i = 0; i < x; i++) {
				this.push(this.shift());
			}
			return this;
		}

		Array.prototype.translate_at_angle = function(dis, theta){
		    for (i = 0; i < this.length; i++){
		    	this[i][0] = this[i][0] + Math.floor(dis * Math.cos(theta));
		    	this[i][1] = this[i][1] + Math.floor(dis * Math.sin(theta));     
		    }
		    return this; 
		}

		function draw_hexagon(center_x, center_y, radius, image_src){
			return draw_reg_polygon(center_x, center_y, radius, 6, image_src);
		}

		function draw_reg_polygon(center_x, center_y, radius, num_sides, image_src){
			svg = d3.select('#officers-portraits');
			points = Array(num_sides);
			clip_points = Array(num_sides);
			for (i = 0; i < num_sides; i++){
				theta = 2 * Math.PI * (i / num_sides) + (Math.PI / 2);
				x = radius * Math.cos(theta) + center_x;
				y = radius * Math.sin(theta) + center_y;
				points[i] = [Math.floor(x), Math.floor(y)];
				pad_x = radius * .95 * Math.cos(theta);
				pad_y = radius * .95 * Math.sin(theta);
				clip_points[i] = [Math.floor(pad_x / (2 * radius) * 100 + 50), Math.floor(pad_y / (2 * radius) * 100 + 50)];

			}
			svg.append("polygon")
				.attr("points", points.map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');
			if (image_src != null){
				clip = "polygon(" + clip_points.map(function(x){return x[0] + "% " + x[1] + "%";}).join(', ') + ")";
				console.log(clip);
				svg.append("image")
					.attr("xlink:href", image_src)
					.attr("x", center_x - r)
					.attr("y", center_y - r)
					.attr("width", 2 * r)
					.attr("height", 2 * r)
					.attr("clip-path", clip);
			}
			return points;
		}

		function draw_stuff(officers) {
			r = 128;
			distance_from_edge = r * Math.sqrt(3);
			start_y = r + 12;
			line_distance = -6
			svg = d3.select('#officers-portraits');
			ma_hex = draw_hexagon(distance_from_edge, start_y, r, officers[0].get_portrait_src());
			vma_hex = draw_hexagon(distance_from_edge, start_y + 3 * r, r, officers[1].get_portrait_src());
			//use polyline so can use points instead of x1,y1,x2,y2
			svg.append("polyline") 
				.attr('points', ma_hex[0].join(',') + " " + vma_hex[3].join(','))
				.attr('class', 'chem-linedraw');
			svg.append("polyline") // double bond
				.attr('points', [ma_hex[0], vma_hex[3]].translate_at_angle(line_distance, 0).join(','))
				.attr('class', 'chem-linedraw');

			line_points = [ma_hex[1], [0, ma_hex[1][1] + Math.floor(r / 2)]]
			svg.append("polyline")
				.attr('points', line_points.map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');
			svg.append("polyline") //double bond
				.attr('points', line_points.translate_at_angle(-line_distance,  2 * Math.PI / 6).map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');

			line_points = [vma_hex[2], [0, vma_hex[2][1] - Math.floor(r / 2)]]
			svg.append("polyline")
				.attr('points', line_points.map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');
			svg.append("polyline") //double bond
				.attr('points', line_points.translate_at_angle(line_distance,  4 * Math.PI / 6).map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');


		}

		// main script
		officers = []
		var xhttp = new XMLHttpRequest();
		xhttp.overrideMimeType('application/xml');
		xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		    	xml = this.responseXML;
		        for (var node = xml.documentElement.firstElementChild; node.nextElementSibling != null; node = node.nextElementSibling) {
		        	officer = Object();
		        	officer.position = node.getElementsByTagName("Position")[0].innerHTML;
		        	officer.fn = node.getElementsByTagName("FirstName")[0].innerHTML;
		        	officer.ln = node.getElementsByTagName("LastName")[0].innerHTML;
		        	officer.major = node.getElementsByTagName("Major")[0].innerHTML;
		      		officer.class = node.getElementsByTagName("Class")[0].innerHTML;
		      		officer.pledgeyear = node.getElementsByTagName("PledgeYear")[0].innerHTML;
		      		officer.email = node.getElementsByTagName("Email")[0].innerHTML;
		      		officer.get_portrait_src = function(){return "images/" + this.fn + "_" + this.ln + ".png";}
		        	officers.push(officer);
		        }

		        draw_stuff(officers)
		    }
		};
		xhttp.open("GET", "officers.xml", true);
		xhttp.send();
		


		</script>
		<?php include('footer.php'); ?> 
	</body>
</html>