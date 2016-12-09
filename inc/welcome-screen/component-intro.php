<?php
/**
 * Welcome screen intro template
 */

?>
<?php
//Prints out the intro section
?>

<section class="intro">
	<p class="about-text"><?php echo sprintf( 
				esc_html__( 
					'%sEnjoying %s?%s Why not %sleave a review%s on WordPress.org? We\'d really appreciate it!', 'brendah' ), 
					'<strong>', 
					'Brendah', 
					'</strong>', 
					'<a href="https://wordpress.org/themes/brendah">', '</a>' 
					); 
		?></p>
</section>
