//params
var STD_LEAF_W = 250;
var STD_LEAF_H = 40;
var STD_LEAF_CORNER_ROUND = 5;
var GOBACK_GENERATIONS = 3;


function children_func(d)
{
	return d.littles;
}

var total_generations = 0;

function get_tree_roots(start_points) 
{
	bros = Array();
	tree_roots = Array();
	bros.add = function(bro){
		if (!this.includes(bro)){
			this.push(bro);
			for (var i = 0; i < bro.littles.length; i++)
			{
				this.add(bro.littles[i]);
			}
		}
	};
	for (var k = 0; k < start_points.length; k++)
	{
		bro = start_points[k];
		ancestor = bro;
		for (var i = 0; i < GOBACK_GENERATIONS; i++)
		{
			if (!bros.includes(ancestor))
				bros.add(ancestor)
			if (tree_roots.includes(ancestor))
				tree_roots.splice(tree_roots.indexOf(ancestor), 1);
			if (ancestor.big_link == null)
				break;
			ancestor = ancestor.big_link;

		}
		if (!bros.includes(ancestor))
		{
			bros.add(ancestor);
			tree_roots.push(ancestor);
		}
	}
	return tree_roots;	
}

function list_tree(r)
{
	var list = [r];
	for (little in r.littles)
	{
		list = list.concat(list_tree(r.littles[little]));
	}
	return list;
}

function draw_trees(selection, roots)
{
	var scale = d3.scaleLinear()
		.domain([0, 1000])
		.range([0, selection.attr("width")]);
	for (r in roots)
	{
		var group = selection.append('g');
		draw_tree(group, scale, roots[r]);
	}
}

function draw_tree(selection, scale, r)
{
	var in_tree = list_tree(r);
	for (branch in in_tree)
	{
		in_tree[branch].x = function(){
			if (!in_tree.includes(this.big_link))
				return 0;
			var num_siblings = this.big_link.littles.length; //number of siblings including self
			return this.big_link.x() + (Math.floor(num_siblings / 2) - this.big_link.littles.indexOf(this)) * STD_LEAF_W;
		};
		in_tree[branch].y = function(){
			if (in_tree.includes(this.big_link))
				return this.big_link.y() + Number(scale(60).slice(0,-2));
			else
				return 0;
		};
	}
	var selector = selection.selectAll("g").data(in_tree).enter();
	var brother_group = selector.append("g");
	brother_group.attr('transform', function(d){
		return "translate(" + d.x() + "," + d.y() + ")";
	});
	brother_group.append("rect")
		.attr("class", "tree-bro-rect")
		.attr("width", scale(STD_LEAF_W))
		.attr("height", scale(STD_LEAF_H))
		.attr("rx", scale(STD_LEAF_CORNER_ROUND))
		.attr("ry", scale(STD_LEAF_W))
	brother_group.append("text")
		.attr("text-anchor", "middle")
		.attr("class", "tree-bro-label")
		.attr("x", scale(STD_LEAF_W / 2))
		.attr("y", scale(STD_LEAF_H / 2))
		.text(function(x){return x.get_name();});
	brother_group.append('line')
		.style("display", function(d, i){
			return in_tree.includes(d.big_link) ? "none" : "default";
		})
		.attr("x1", function(d, i){
			return in_tree.includes(d.big_link) ? 0 : d.big_link.x() + scale(STD_LEAF_W / 2);
		})
		.attr("y1", function(d, i){
			return in_tree.includes(d.big_link) ? 0 : d.big_link.y() + scale(STD_LEAF_H);
		})
		.attr("x2", function(d, i){
			return scale(STD_LEAF_W / 2);
		})
		.attr("y2", function(d, i){
			return 0;
		})
}