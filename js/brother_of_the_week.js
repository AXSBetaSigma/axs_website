var botws = [];
var bros = [];
var get = function(date=null, start=null, end=null){
	if (date == null)
		date = new Date();
	if (start == null)
	{
		start = 0;
		if (botws[start].week_end.getTime() < date.getTime()) // if more recent than any BoTW
			return null;
	}
	if (end == null)
	{
		end = botws.length;
		if (date.getTime() < botws[end - 1].week_of.getTime()) // if older than any BoTW
			return null;
	}
	var halfpoint = Math.floor((end + start) / 2);
	var b = botws[halfpoint];
	if (b.week_of.getTime() <= date.getTime() && date.getTime() <= b.week_end.getTime())
		return b;
	else if (end - start == 1)
		return null;
	else if (date.getTime() < b.week_of.getTime())
		return get(date, halfpoint, end); // because reverse order, lower date val -> higher idx
	else if (b.week_end.getTime() < date.getTime())
		return get(date, start, halfpoint); // because reverse order, higher date val -> lower idx
};

function draw_botw(d=null){
	var botw = get(d);
	var selector = "[class='botw']" + (d != null ? "[name='dateof" + d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "']" : "");	
	var botw_top = $(selector);
	botw_top.append($('<h2>Brother of the Week</h2><h1></h1>'));
	if (botw == null)
		botw_top.append($('<p>No Brother of the Week this week! Check back next week!</p>'));
	else
	{
		$(selector + ' h1').html(botw.bro.get_name());
		for (var i = 0; i < botw.num_pics; i++)
		{
			if (i == botw.num_pics / 2)
				botw_top.append($('<br>'));
			var pic = $('<img class="botw-pic" src="' + botw.pic(i+1) + '">');
			botw_top.append(pic);
		}
		botw_top.append($('<figcaption></figcaption>'));
		$(selector + ' figcaption').html(botw.bro.bio);
	}	
}

function load_botw_xml(do_after){
	$.ajax({
		url: 'brothers.xml',
		success: function(b_xml){
			var is_active = function(bro){
                return !bro.has_one_of_positions(["Alum"]);
			};
			load_brothers(b_xml, bros, filter=is_active);
			$.ajax({
				url: 'botw_record.xml',
				success: function(botw_xml){
					for (var node = botw_xml.documentElement.firstElementChild; node != null; node = node.nextElementSibling)
			        {
			        	var botw = Object();
			           	botw.id = node.getElementsByTagName('ID')[0].innerHTML;
						botw.week_of = new Date(node.getElementsByTagName('WeekOf')[0].innerHTML);
						botw.week_end = new Date(botw.week_of);
						botw.week_end.setDate(botw.week_end.getDate() + 7);
						botw.num_pics = read_if_exists(node, 'NumPics', 4);
						botw.bro = bros.get(botw.id);
						if (botw.bro == null)
							Console.log("BoTW hould not be null. id=" + botw.id);
						botw.pic = function(num) {
							return "images/botw/" + this.bro.id + "/" + "pic" + num + ".png";
						}
						botws.push(botw);
					}
					do_after();
				}
			});
		}
	});
}