var bros = [];

var xhttp = new XMLHttpRequest();
xhttp.overrideMimeType('application/xml');
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	xml = this.responseXML;
    	alphabet_sort = function(a,b){
    		return (a.fn + a.ln) < (b.fn + b.ln);
    	};
        load_brothers(xml, bros, function(x){return true;}, alphabet_sort);

        init_treepage();
    }
};
xhttp.open("GET", "brothers.xml", true);
xhttp.send()

function init_treepage()
{
	d3.select("#tree-root-select").selectAll("option").data(bros).enter()
		.append('option')
			.attr("value", function(d){return d.id;})
			.text(function(d){return d.get_name();});
	// var roots = "[value=CraigSzymanski], [value=JenniferJankauskas], [value=SamBrett], [value=GlennRobinson]";
	var roots = "[value=JenniferJankauskas]";
	d3.select("#tree-root-select").selectAll(roots).attr('selected','true');
	draw_tree();
}

function children_func(d)
{
	return d.littles;
}

function draw_tree()
{
	var selected = d3.selectAll("#tree-root-select [selected]")
	var tree = null;
	if (selected.length == 1)
	{
		tree = d3.heirarchy(selected.node());
	}
	else
	{

	}
}
