<?php
// header('Content-Type: text/xml');

include 'plugins/ranger.php';

if (!array_key_exists('id', $_GET)) {
	$id = 0;
}
else {
	$id = $_GET['id'];
}

$xml = simplexml_load_file("gallery_pics.xml");
foreach ($xml->children() as $n){
	// echo $n->PicID . " " . $id;
 	if ($id == 0 or strcmp($n->PicID, $id) == 0){
		$dims = getjpegsize("./images/gallery/" . $n->PicID . ".jpg");
		$n->addChild('Width', $dims[0]);
		$n->addChild('Height', $dims[1]);
		if (strcmp($n->PicID,$id) == 0){
			echo $n->asXML();
			break;
		}
	}
}
if ($id == 0) {
	echo $xml->asXML();
}
?>