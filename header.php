<header class="container-fluid">
	<img id='logo-image' src='images/axs_logo.png'>
	<h6 class='text-uppercase'>professional co-ed chemistry fraternity</h6>
	<h1 class='text-uppercase'>alpha chi sigma</h1>
	<h5>beta sigma chapter</h5>
	<ul id="main-nav-bar" class="container-fluid nav nav-pills nav-fill text-uppercase" style="clear: both;">
		<li class="nav-item">
			<a class='nav-link' href="index.php">home</a>
		</li>
		<li class="nav-item" >
			<a class='nav-link' href="events.php">events</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="become_a_brother.php">become a Brother</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="about_us.php">about us</a>
		</li>
		<li class="nav-item">
			<a class='nav-link' href="contact_us.php">contact us</a>
		</li>
	</nav>
</header>
<script>
navbar = document.getElementById("main-nav-bar")
for (node=navbar.firstElementChild; node != null; node = node.nextElementSibling) {

	links_to = node.firstElementChild.attributes['href'].value;
	console.log(links_to);
	if (location.pathname.endsWith(links_to)) {
		node.classList.add("active");
		break;
	}
}
</script>