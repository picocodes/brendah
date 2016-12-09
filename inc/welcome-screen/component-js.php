<?php
/**
 * Welcome screen js template
 */

?>
<script>
	jQuery( window ).load( function() {
		jQuery( '.brendah-boards' ).masonry({
			itemSelector: 		'.brendah-board',
			columnWidth: 		'.brendah-board',
			percentPosition: 	true
		});
	});
</script>