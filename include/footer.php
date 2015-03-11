<footer>
	<div>
		<div class='row footer-nav'>
			<div class='col-md-offset-1 col-md-3'>
				<h6>Get To Know Us</h6>
				<a href="">About Us</a><br />
				<a href="">Press Releases</a><br />
				<a href="">Careers</a><br />
			</div>
			<div class='col-md-3'>
				<h6>Connect With Us</h6>
				<a href="">Facebook</a><br />
				<a href="">Twitter</a><br />
				<a href="">Youtube</a><br />
				<a href="">Instagram</a><br />
			</div>
			<div class='col-md-3'>
				<h6>Help</h6>
				<a href="">Contact Us</a><br />
				<a href="">FAQs</a><br />
				<a href="">Returns &amp; Cancellation</a><br />
			</div>
			<div class='col-md-2'>
				<h6>Misc</h6>
				<a href="">Online Shopping</a><br />
				<a href="">Gift Vouchers</a><br />
			</div>
		</div> <!-- end of the row -->
		<div class="row footer">
			<ul>
				<li><a href="">Terms of Use</a></li>
				<li><a href="">Privacy Note</a></a></li>
				<li><a href="">Security</a></li>
				<li>&copy; 2015,&nbsp;&nbsp;bca.com&nbsp;&nbsp;<a href='http://www.samboupha.com'>Sam Boupha<a></li>
			</ul>
		</div>
	</div>
</footer>

<!-- js script -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
		// <<< to manipulate login drop_down
		$('div.account').hover( function() { $('.dropdown-menu').show() }, 
								function() { $('.dropdown-menu').hide(); });

		$('.dropdown-toggle').dropdown();
		// >>>
		
		// <<< needed to manipulate side_nav
		$('ul.sub_menu a > li:contains(Dress)').click( function() {
			$('ul.sub_menu a').attr('href','clothes.php?section=2&category=2');
		});

		$('ul.sub_menu a > li:contains(Blazer)').click( function() {
			$('ul.sub_menu a').attr('href','clothes.php?section=1&category=1');
		});
		// >>>

		</script>
	</body>
</html>