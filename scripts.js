function load_brothers(xml, list, filter=function(x){return true;}, sort_function=null) {
	for (var node = xml.documentElement.firstElementChild; node != null; node = node.nextElementSibling) {
    	bro = Object();
    	bro.position = node.getElementsByTagName("Position")[0].innerHTML;
    	bro.fn = node.getElementsByTagName("FirstName")[0].innerHTML;
    	bro.ln = node.getElementsByTagName("LastName")[0].innerHTML;
    	bro.major = node.getElementsByTagName("Major")[0].innerHTML;
  		bro.class = node.getElementsByTagName("Class")[0].innerHTML;
  		bro.pledgeyear = node.getElementsByTagName("PledgeYear")[0].innerHTML;
        if (node.getElementsByTagName("Email").length > 0) {
            bro.email = node.getElementsByTagName("Email")[0].innerHTML;
        }
        else {
            bro.email = "n/a";
        }
  		bro.bio = node.getElementsByTagName("Bio")[0].innerHTML;
        bro.pic = "images/bro_portraits/" + bro.fn + "_" + bro.ln + ".png";
        if (!url_exists(bro.pic)) {
            bro.pic = "images/no_pic.png";
        }
  		bro.get_portrait_src = function(){return this.pic;}
        bro.has_portrait = function(){
            return this.pic != "images/no_pic.png";
        }
        bro.has_position = function(){
            return this.position != "Active" && this.position != "Alum" && this.position != "Inactive";
        }
        bro.has_bio = function() {
            return this.bio.replace(/^\s+/, '').replace(/\s+$/, '') != "";
        }
  		if (filter(bro))
    		list.push(bro);
    }
    if (sort_function != null) {
        // bubble sort should be fine.
        for (var j = 0; j < list.length; j++){
            for (var i = 0; i < list.length - 1; i++){
                if (sort_function(list[i], list[i + 1])) {
                    var holder = list[i];
                    list[i] = list[i + 1];
                    list[i + 1] = holder;
                }
            }
        }
    }

}


//This function blatantly plagerized from Adam Plocher on Stack Overflow. https://stackoverflow.com/a/3646923
function url_exists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}