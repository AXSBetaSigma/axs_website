function load_brothers(xml, list, filter=function(x){return true;}, sort_function=null) {
	for (var node = xml.documentElement.firstElementChild; node != null; node = node.nextElementSibling) {
    	bro = Object();
        //position / positions is/are... difficult
        bro.positions = [];
        var pos_node = node.getElementsByTagName("Position");
        for (var child = 0; child < pos_node.length; child++)
        {
            bro.positions.push(pos_node[child].innerHTML);
        }
    	bro.fn = node.getElementsByTagName("FirstName")[0].innerHTML;
        bro.mn = read_if_exists(node, "MiddleName");
    	bro.ln = node.getElementsByTagName("LastName")[0].innerHTML;
        bro.suffix = read_if_exists(node, "Suffix");
        bro.big = read_if_exists(node, "Big");
    	bro.major = read_if_exists(node, "Major", "Unknown");
  		bro.class = node.getElementsByTagName("Class")[0].innerHTML;
  		bro.pledgeyear = node.getElementsByTagName("PledgeYear")[0].innerHTML;
        bro.email = read_if_exists(node, "Email");
  		bro.bio = read_if_exists(node, "Bio");
        bro.pic = "images/bro_portraits/" + bro.fn + "_" + bro.ln.replace(' ','').replace('-','').replace('.','')  + ".png";
        if (node.getElementsByTagName("HasPic").length  == 0) {
            bro.pic = "images/no_pic.png";
        }
        if (node.getElementsByTagName("ID").length > 0)
            bro.id = node.getElementsByTagName("ID")[0].innerHTML;
        else
            bro.id = bro.fn + bro.mn + bro.ln;
        bro.littles = [];
  		bro.get_portrait_src = function(){return this.pic;}
        bro.has_portrait = function(){
            return this.pic != "images/no_pic.png";
        };
        bro.has_position = function(position_name=null){
            if (position_name == null)
            {
                return !this.has_one_of_positions(["Active","Alum","Inactive","NIB"]);
            }
            else {
                return this.positions.index_of(position_name) > -1;
            }
        };

        bro.has_one_of_positions = function(positions)
        {
            return index_contains(positions, this.positions) > -1;
        };

        bro.has_bio = function() {
            return this.bio.replace(/^\s+/, '').replace(/\s+$/, '') != "";
        };
        bro.get_name = function() {
            var name = this.fn + " ";
            if (this.mn != "")
                name = name + this.mn + " ";
            name = name + this.ln;
            if (this.suffix != "")
                name = name + " " + this.suffix;
            return name;
        };
  	 	if (filter(bro))
        {
    		list.push(bro);
        }
        list.get = function(id){
            for (i in this) {
                if (this[i].id == id)
                    return this[i];
            }   
            return null;
        }
    }

    // these two loops could prob. be merged but i tried and it was *hard*
    for (var i = 0; i < list.length; i++)
    {
        var littlecheck = list[i]
        for (var k = 1; k < list.length; k++){
            var bigcheck = list[(i + k) % list.length]
            if (littlecheck.big == bigcheck.get_name()) // if littlecheck is bigcheck's little
            {
                littlecheck.big_link = bigcheck;
                bigcheck.littles.push(littlecheck);
                break;
            }
        }
        if (littlecheck.big_link == null)
            console.log(littlecheck.get_name() + " does not have a big. Is this okay?");
        list[i].is_ancestor = function(other){
            var n = this.big_link;
            while (n != null)
            {
                if (n == other) {
                    return true;
                }
                n = n.big_link;
            }
            return false;
        };
    }
    // bubble sort should be fine.
    if (sort_function != null) {
        var list_sorted = false;
        for (var j = 0; j < list.length; j++){
            list_sorted = true; // assume the list is sorted. if any of the order needs to be corrected, it's not sorted
            for (var i = 0; i < list.length - 1; i++){ 
                var a = list[i];
                var b = list[i + 1];

                if (sort_function(a, b)) {
                    list[i] = b;
                    list[i + 1] = a;
                    list_sorted = false;
                }
            }
            if (list_sorted) //if no items are out of order, exit the sort loop
                break;
        }
    }
}

function brothers_with_positions(list, positions)
{
    var  positions_filled = 0;
    var ordered_list = new Array(positions.length);
    for (var i = 0; i < list.length && positions_filled < positions.length; i++) {
        var bro = list[i];
        if (bro.has_position())
        {
            var position_idx = index_contains(positions, bro.positions);
            if (position_idx > -1)
            {
                ordered_list[position_idx] = bro;
                positions_filled++;
            }
        }
    }
    return ordered_list;
}

function load_gallery(list, filter=function(x){return true;}, do_with)
{
    $.ajax({
   		url: "gallery_preprocess.php",
   		success: function() {
	        for (var node = this.responseXML.documentElement.firstElementChild; node != null; node = node.nextElementSibling)
	        {
	           	var img = parse_image_data(node);
	           	if (filter(img))
	            {
	                list.push(img);
	            }
	            do_with(list)
	        }
	    }
    });
    xhttp.open("GET", "gallery_preprocess.php", true);
    xhttp.send();
}

function parse_image_data(node)
{
	var img = Object();
    img.date = Date(node.getElementsByTagName("Date")[0].innerHTML);
    img.pic_id = node.getElementsByTagName("PicID")[0].innerHTML;
    img.caption = node.getElementsByTagName("Caption")[0].innerHTML;
    img.bros = [];
    var bros_node = node.getElementsByTagName("Brothers");
    if (bros_node.length > 0)
    {
        for (var k = bros_node[0].firstElementChild; k != null; k = k.nextElementSibling)
        {
            img.bros.push(k.innerHTML);
        }
    }
    img.tags = [];
    var tags_node = node.getElementsByTagName("Tags");
    if (tags_node.length > 0)
    {
        for (var k = tags_node[0].firstElementChild; k != null; k = k.nextElementSibling)
        {
            img.tags.push(k.innerHTML);
        }
    }
    //the following properties are used by photoswipe and must retain the same names
    img.title = node.getElementsByTagName("Title")[0].innerHTML;
    img.src = "./images/gallery/" + img.pic_id + ".jpg";
    img.width = node.getElementsByTagName("Width")[0].innerHTML;
    img.height = node.getElementsByTagName("Height")[0].innerHTML;
    return img;
}

function load_image(img_id, do_with)
{
   	$.ajax({
   		url: "gallery_preprocess.php?id=" + img_id,
   		success: function(result) {
   			var elmnt = $.parseXML(result).documentElement;
			var img = parse_image_data(elmnt);
			do_with(img);
    	}
    });
}

function index_contains(haystack, needles)
{
    for (var i = 0; i < haystack.length; i++)
    {
        for (var j = 0; j < needles.length; j++)
        {
            if (haystack[i] == needles[j])
                return i;
        }    
    }
    return -1;
}

//This function blatantly plagerized from Adam Plocher on Stack Overflow. https://stackoverflow.com/a/3646923
function url_exists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}

function read_if_exists(parentNode, tag, default_val="") {
    elmts = parentNode.getElementsByTagName(tag);
    if (elmts.length > 0)
    {
        return elmts[0].innerHTML;
    }
    else {
        return default_val;
    }
}