<header class="container-fluid">
	<div class="container header-subsection">
		<img id='logo-image' src='images/axs_logo.png'>
	</div>
	<div class="container header-subsection center-subsection">
		<h6 class='text-uppercase'>professional co-ed chemistry fraternity</h6>
		<h1 class='text-uppercase'>alpha chi sigma</h1>
		<h5 class='text-uppercase'>beta sigma chapter</h5>
	</div>
	<div class="container header-subsection text-uppercase" id="aims">
		&#11041; to bind<br>
		&#11041; to strive<br>
		&#11041; to aid
	</div>
	<ul id="main-nav-bar" class="container-fluid nav nav-pills nav-fill text-uppercase" style="clear: both;">
		<li class="nav-item">
			<a class='nav-link' href="index.php">home</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="about_us.php">about us</a>
		</li>
		<li class="nav-item" >
			<a class='nav-link' href="events.php">events</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="meet_brother.php">meet the brothers</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="become_a_brother.php">become a brother</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="https://www.alphachisigma.org/">national website</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="social_media.php">social media</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="contact_us.php">contact us</a>
		</li>
	</ul>
	<div id="mobile-nav-bar" class="dropdown text-uppercase">
  		<button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    		&#9776; Navigation
  		</button>
  		<div class="dropdown-menu" id="mobile-nav-dropdown" aria-labelledby="dropdownMenuButton">
	    	<a class="dropdown-item nav-item nav-link" href="index.php">home</a>
	    	<a class="dropdown-item nav-item nav-link" href="about_us.php">about us</a>
	    	<a class="dropdown-item nav-item nav-link" href="events.php">events</a>
	    	<a class="dropdown-item nav-item nav-link" href="meet_brother.php">meet the brothers</a>
	    	<a class="dropdown-item nav-item nav-link" href="become_a_brother.php">become a brother</a>
	    	<a class="dropdown-item nav-item nav-link" href="https://www.alphachisigma.org/">national website</a>
	    	<a class="dropdown-item nav-item nav-link" href="social_media.php">social media</a>
	    	<a class="dropdown-item nav-item nav-link" href="contact_us.php">contact us</a>
  		</div>
	</div>
</header>
<script>
navbar = document.getElementById("main-nav-bar")
for (node=navbar.firstElementChild; node != null; node = node.nextElementSibling) {

	links_to = node.firstElementChild.attributes['href'].value;
	if (location.pathname.endsWith(links_to)) {
		node.classList.add("active");
		break;
	}
}
</script>