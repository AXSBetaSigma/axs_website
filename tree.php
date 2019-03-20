<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma</title>
		<?php include('imports.php') ?>
	</head>
	<body>
		<main>
			<?php include('header.php'); ?>
			<select multiple id="tree-root-select" onchange="refresh_tree()"></select>
			<svg id="tree-svg" width='800px'>
			</svg>
			<script type="text/javascript" src="js/tree.js"></script>
			<script type="text/javascript">
				var bros = [];
				$.ajax({
					url: 'brothers.xml',
					success: function(xml){
						// xml = $.parseXML(result);
						alphabet_sort = function(a,b){
				    		return (a.fn + a.ln) < (b.fn + b.ln);
				    	};
				        load_brothers(xml, bros, function(x){return true;}, alphabet_sort);

						d3.select("#tree-root-select").selectAll("option").data(bros).enter()
							.append('option')
							.attr("value", function(d){return d.id;})
							.text(function(d){return d.get_name();});
						// var roots = "[value=CraigSzymanski], [value=JenniferJankauskas], [value=SamBrett], [value=GlennRobinson]";
						// var roots = "[value=JenniferJankauskas]";
						// d3.select("#tree-root-select").selectAll(roots).attr('selected','true');
						refresh_tree();
					},
					error: function(jq, status, error){
						console.log(error.message);
					}
				
				});
				function refresh_tree()
				{
				    var selected = $("#tree-root-select").map(function(){return this.value;});
				    if (selected.length)
					    selected = bros.filter(function(x){return x.positions[0] != "Alum";});
				    var trees = get_tree_roots(selected);
				    draw_trees(d3.select('#tree-svg'), trees);
				}

			</script>
		</main>
	</body>
</html>