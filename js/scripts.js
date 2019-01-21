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
        bro.pic = "images/bro_portraits/" + bro.fn + "_" + bro.ln + ".png";
        if (node.getElementsByTagName("HasPic").length  == 0) {
            bro.pic = "images/no_pic.png";
        }
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
            return this.fn + " " + this.mn + " " + this.ln + " " + this.suffix;
        };
  	 	if (filter(bro))
        {
    		list.push(bro);
        }
    }
    if (sort_function != null) {
        // bubble sort should be fine.
        for (var j = 0; j < list.length; j++){
            for (var i = 0; i < list.length -  1; i++){
                var a = list[i];
                var b = list[i + 1];
                if (sort_function(a, b)) {
                    list[i] = b;
                    list[i + 1] = a;
                }
                if ( list[j].big_link == undefined && list[j].big != "" && list[j].big.replace(' ', '') == a.id)
                {
                    list[j].big_link = a;
                    a.littles.push(list[j]);
                }
                else {
                    list[j].big_link = null;
                }
            }    
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

function order_by(a, b, positions_order)
{

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