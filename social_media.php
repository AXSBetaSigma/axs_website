<!doctype html>
<html>
	<head>
		<title>AXS Beta Sigma</title>
		<?php include('imports.php') ?>
		<style>
			#top-container {
				display: flex;
				flex-flow: row;
				justify-content: space-around;
				margin-top: 10pt;
			}

			#twitter, #instagram {
				/*display: inline-block;*/
				/*width: 40%;*/
				border: 2px solid var(--prussian-blue);
				margin: 5px 5px 5px 5px;
				border-radius: 8px;
				padding: 1% 1% 1% 1%;
			}

			#twitter {
				/*margin-right: auto;*/
			}

			#instagram {
				/*margin-left: auto;*/
			}

			h4 {
				text-align: center;
			}
		</style>
	</head>
	<body>
		<main>
			<?php include('header.php'); ?>
			<div id=top-container>
				<div id="twitter">
					<h4>Twitter</h4>
					<a class="twitter-timeline" data-height="600" href="https://twitter.com/AXSBetaSigma?ref_src=twsrc%5Etfw">Tweets by AXSBetaSigma</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
				</div>
				<div id="instagram">
					<h4>Instagram</h4>
					<div id="pixlee_container">
						
					</div>
					<script type="text/javascript">window.PixleeAsyncInit = function() {Pixlee.init({apiKey:'cooNhqz5oimG35IZxLFq'});Pixlee.addSimpleWidget({widgetId:'15574'});};</script>
					<script src="//instafeed.assets.pixlee.com/assets/pixlee_widget_1_0_0.js"></script>
				</div>
			</div>
			<?php include('footer.php'); ?> 
		</main>
	</body>
</html>