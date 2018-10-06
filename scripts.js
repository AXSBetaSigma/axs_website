function load_brothers(xml, list, filter=function(x){return true;}) {
	for (var node = xml.documentElement.firstElementChild; node != null; node = node.nextElementSibling) {
    	bro = Object();
    	bro.position = node.getElementsByTagName("Position")[0].innerHTML;
    	bro.fn = node.getElementsByTagName("FirstName")[0].innerHTML;
    	bro.ln = node.getElementsByTagName("LastName")[0].innerHTML;
    	bro.major = node.getElementsByTagName("Major")[0].innerHTML;
  		bro.class = node.getElementsByTagName("Class")[0].innerHTML;
  		bro.pledgeyear = node.getElementsByTagName("PledgeYear")[0].innerHTML;
  		bro.email = node.getElementsByTagName("Email")[0].innerHTML;
  		bro.bio = node.getElementsByTagName("Bio")[0].innerHTML;
  		bro.get_portrait_src = function(){return "images/" + this.fn + "_" + this.ln + ".png";}
  		if (filter(bro))
    		list.push(bro);
    }
}