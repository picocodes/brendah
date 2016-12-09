<?php
/**
 * Welcome screen show boards
 *
 */

?>
<div class="brendah-boards">
<?php

if ( is_array( $boards ) ) {
	
	foreach ( $boards as $boards => $details ) {
		
		echo '<div class="brendah-board">';
		
		if ( isset( $details['title'] ) ) {
			
			echo '<h2 class="hndle"><span>'. $details['title'] .'</span></h2>';
			
		}
		
		if ( isset( $details['description'] ) ) {
			
			echo '<p>'. $details['description'] .'</p>';
			
		}
		
		if ( isset( $details['link'] ) ) {
			
			echo $details['link'];
			
		}
		
		echo '</div>';
		
	}
	
}
?>
</div>