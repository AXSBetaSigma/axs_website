<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma - Contact Us</title>
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel='stylesheet' href='css/bootstrap.css' type='text/css'>
		<link rel='stylesheet' href='style.css' type='text/css'>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script src="https://d3js.org/d3.v4.min.js"></script>
		<script type="text/javascript" src="scripts.js"></script>
	</head>
	<body onresize="draw_stuff()">
		<?php include('header.php'); ?>
		<h3>Contact Us</h3>
		<p>
			Get in touch with one of our four officers!
		</p>
		<svg id='officers-portraits' width='100%'>
		</svg>
		<script>

		officers = []

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

		function draw_hexagon(parent, center_x, center_y, radius, image_src){
			return draw_reg_polygon(parent, center_x, center_y, radius, 6, image_src);
		}

		function draw_reg_polygon(parent, center_x, center_y, radius, num_sides, image_src){
			svg = d3.select('#officers-portraits');
			points = Array(num_sides);
			clip_points = Array(num_sides);
			for (i = 0; i < num_sides; i++){
				theta = 2 * Math.PI * (i / num_sides) + (Math.PI / 2);
				var x = radius * Math.cos(theta) + center_x;
				var y = radius * Math.sin(theta) + center_y;
				points[i] = [Math.floor(x), Math.floor(y)];
				pad_x = radius * .95 * Math.cos(theta);
				pad_y = radius * .95 * Math.sin(theta);
				clip_points[i] = [Math.floor(pad_x / (2 * radius) * 100 + 50), Math.floor(pad_y / (2 * radius) * 100 + 50)];

			}
			parent.append("polygon")
				.attr("points", points.map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');
			if (image_src != null){
				clip = "polygon(" + clip_points.map(function(x){return x[0] + "% " + x[1] + "%";}).join(', ') + ")";
				parent.append("image")
					.attr("xlink:href", image_src)
					.attr("x", center_x - radius)
					.attr("y", center_y - radius)
					.attr("width", 2 * radius)
					.attr("height", 2 * radius)
					.attr("clip-path", clip)
			}
			return points;
		}

		function draw_stuff() {
			svg = d3.select('#officers-portraits');
			svg.selectAll("g").remove();
			svg.selectAll("polyline").remove();
			var r = 128;

			if (window.innerWidth < (r * 12)) {
				svg.attr('height', 12 * r);
			}
			else {
				svg.attr('height', 6 * r);
			}


			distance_from_edge = r * Math.sqrt(3);
			var y = r + 12;
			line_distance = -6;

			ma_hex = draw_officer(officers[0], distance_from_edge, y, r, 1);
			vma_hex = draw_officer(officers[1], distance_from_edge, y + 3 * r, r, 1);
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

			if (window.innerWidth < (r * 12)) {
				y = y + (6 * r);
			}

			mc_hex = draw_officer(officers[2], window.innerWidth - distance_from_edge, y, r, -1);
			treasurer_hex = draw_officer(officers[3], window.innerWidth - distance_from_edge, y + 3 * r, r, -1);
			//use polyline so can use points instead of x1,y1,x2,y2
			svg.append("polyline") 
				.attr('points', mc_hex[0].join(',') + " " + treasurer_hex[3].join(','))
				.attr('class', 'chem-linedraw');
			svg.append("polyline") // double bond
				.attr('points', [mc_hex[0], treasurer_hex[3]].translate_at_angle(line_distance, 0).join(','))
				.attr('class', 'chem-linedraw');

			line_points = [mc_hex[5], [window.innerWidth, mc_hex[1][1] + Math.floor(r / 2)]]
			svg.append("polyline")
				.attr('points', line_points.map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');
			svg.append("polyline") //double bond
				.attr('points', line_points.translate_at_angle(-line_distance,  4 * Math.PI / 6).map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');

			line_points = [treasurer_hex[4], [window.innerWidth, treasurer_hex[2][1] - Math.floor(r / 2)]]
			svg.append("polyline")
				.attr('points', line_points.map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');
			svg.append("polyline") //double bond
				.attr('points', line_points.translate_at_angle(line_distance,  2 * Math.PI / 6).map(coords_to_str).join(' '))
				.attr('class', 'chem-linedraw');

		}

		function draw_officer(officer, x, y, r, direction){
			svg = d3.select('#officers-portraits');
			group = svg.append('g')
				.attr('name', officer.fn + officer.ln);
			hex = draw_hexagon(group, x, y, r, officer.get_portrait_src());
			h = r / 6;
			l1 = group.append('text')
				.text(officer.position + " - " + officer.fn + " " + officer.ln + " - " + officer.pledgeyear)
				.attr('class', 'officer-label')
				.attr('x', x + direction * r)
				.attr('y', y - (r / 2) + h);
			l2 = group.append('text')
				.text(officer.major + " - " + officer.class)
				.attr('class', 'officer-label')
				.attr('x', x + direction * r)
				.attr('y', y - (h / 2) + h);
			l3 = group.append('text')
				.text(officer.email)
				.attr('class', 'officer-label')
				.attr('x', x + direction * r)
				.attr('y', y + (r / 2));
			if (direction == -1){
				l1.style('text-anchor', 'end');
				l2.style('text-anchor', 'end');
				l3.style('text-anchor', 'end');
			}
			return hex
		}

		// main script
		var xhttp = new XMLHttpRequest();
		xhttp.overrideMimeType('application/xml');
		xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		    	xml = this.responseXML;
		    	filter = function(x){
		    		return ((x.position == "Master Alchemist") || (x.position == "Vice-Master Alchemist") || (x.position == "Treasurer") || (x.position == "Master of Ceremonies"));
		    	}
		        load_brothers(xml, officers, filter);

		        draw_stuff();
		    }
		};
		xhttp.open("GET", "brothers.xml", true);
		xhttp.send();
		

		</script>
		<?php include('footer.php'); ?> 
	</body>
</html>