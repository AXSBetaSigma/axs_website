<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma - Meet the Brothers</title>
			<?php include('imports.php') ?>
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
					section.append("h4")
						.attr("class", "bro-position")
						.html(function(x){return x.positions.join(", ");})
						.style("display",function(x){
							if (x.has_position())
								return "initial";
							else
								return "none";
						});
					section.append("br")
					section.append("p")
						.attr("class", "bro-bio")
						.html(function(x){return x.bio;});
				}

				// main script
				$.ajax({
					url: 'brothers.xml',
					success: function(xml) {
				    	filter = function(x){
				    		return x.positions[0] != "Alum";//x.position != "Alum" && (x.has_bio() || x.has_portrait());
				    	}
				    	sort_func = function(a, b){
				    		var eboard = ['Master Alchemist', 'Vice-Master Alchemist', 'Master of Ceremonies', 'Treasurer'];
				    		//todo: possibly add more sorting
				    		//eboard gets priority
				    		if (b.has_one_of_positions(eboard))
			    			{
			    				if  (!a.has_one_of_positions(eboard))
			    				{
			    					return true;
			    				}
			    				else //if both are on eboard, sort in order
			    				{
			    					var a_pos_idx = index_contains(eboard, a.positions);
    								var b_pos_idx = index_contains(eboard, b.positions);
    								return b_pos_idx < a_pos_idx;
			    				}
				    		}
				    		if (b.has_position() != a.has_position()){
				    			return (b.has_position() && !a.has_position());
				    		}

				    		if (b.has_portrait() != a.has_portrait()) {
				    			return b.has_portrait() && !a.has_portrait();
				    		}
				    	}
				        load_brothers(xml, bros, filter, sort_func);
				        draw_brothers();
					}
				});
			</script>
			<?php include('footer.php'); ?> 
		</main>
	</body>
</html>