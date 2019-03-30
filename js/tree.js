//params
var STD_LEAF_W = 250;
var HOR_PAD = 1.1
var STD_LEAF_H = 40;
var VERT_PAD = 2
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

function draw_trees(roots)
{
	var navselect = d3.select('#trees-nav');
	navselect = navselect.selectAll("li").data(roots).enter();
	navselect.append("li")
		.attr("class", "nav-item tree-nav-item")
		.attr("name", function(d){return d.id;})
		.text(function(d){return d.get_name() + " Tree";})
		.on("click", function(d, a, i){switch_tree(d, a);});
	var tree;
	for (r in roots)
	{
		tree = draw_tree(roots[r]);
		tree.css('display', 'none');
	}
	tree.css('display', 'block');
}

function switch_tree(d, a)
{
	// show currently ative tree, not others
	$('.tree-svg').not('[name="' + d.id + '"]').css('display', 'none');
	$('.tree-svg[name="' + d.id + '"]').css('display', 'block');
	// set currently active item to active and not the others
	$(d).attr("class", "nav-item tree-nav-item active");
	$('.tree-nav-item').not($(a)).attr("class", "nav-item tree-nav-item");
}

function draw_tree(root)
{
	// add nav option
	var canvas = $("<svg class='tree-svg'></svg>");
	canvas.attr('name', root.id);
	$("#tree-container").append(canvas);
	var in_tree = list_tree(root);
	for (branch in in_tree)
	{
		in_tree[branch].x = function(){
			if (!in_tree.includes(this.big_link))
				return 500; // "middle", but how exactly to calculate that is still up in the air.
			var num_siblings = this.big_link.littles.length; //number of siblings including self
			if (num_siblings == 1) {
				return this.big_link.x();
			}
			var little_idx = num_siblings / 2 - this.big_link.littles.indexOf(this);
			return this.big_link.x() + num_siblings * STD_LEAF_W * (little_idx / num_siblings) * HOR_PAD - (STD_LEAF_W / 2);
			// return this.big_link.x() + (Math.floor(num_siblings / 2) - this.big_link.littles.indexOf(this)) * STD_LEAF_W;
		};
		in_tree[branch].y = function(){
			if (in_tree.includes(this.big_link))
				return this.big_link.y() + STD_LEAF_H * VERT_PAD;
			else
				return HOR_PAD * STD_LEAF_H;
		};
	}
	var selector = d3.select(canvas[0]).selectAll("g").data(in_tree).enter();
	var brother_group = selector.append("g");
	brother_group.attr('transform', function(d){
		return "translate(" + d.x() + "," + d.y() + ")";
	});
	brother_group.attr('name', function(d){return d.id;})
	brother_group.append("rect")
		.attr("class", "tree-bro-rect")
		.attr("width", STD_LEAF_W)
		.attr("height", STD_LEAF_H)
		.attr("rx", STD_LEAF_CORNER_ROUND)
		.attr("ry", STD_LEAF_W)
	brother_group.append("text")
		.attr("text-anchor", "middle")
		.attr("class", "tree-bro-label")
		.attr("x", STD_LEAF_W / 2)
		.attr("y", STD_LEAF_H / 2)
		.text(function(x){return x.get_name();});
	brother_group.append('line')
		.style("display", function(d, i){
			return in_tree.includes(d.big_link) ? "default" : "none";
		})
		.attr("x1", function(d, i){
			return in_tree.includes(d.big_link) ? d.big_link.x() - d.x() + STD_LEAF_W / 2 : 0;
		})
		.attr("y1", function(d, i){
			return in_tree.includes(d.big_link) ? - d.y() + d.big_link.y() + STD_LEAF_H : 0;
		})
		.attr("x2", function(d, i){
			return STD_LEAF_W / 2;
		})
		.attr("y2", function(d, i){
			return 0;
		}); 
	var max_w = Math.max.apply(null, in_tree.map(function(d){return d.x() + STD_LEAF_W * VERT_PAD;}));
	var max_h = Math.max.apply(null, in_tree.map(function(d){return d.y() + STD_LEAF_H * HOR_PAD * 2;}));
	canvas.attr('width', max_w);
	canvas.attr('height', max_h);
	return canvas;
}