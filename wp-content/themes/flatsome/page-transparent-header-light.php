<?php
/*
Template name: Page - Full Width - Transparent Header - Light Text
*/
get_header(); ?>

<?php do_action( 'flatsome_before_page' ); ?>

<div id="content" role="main">
<?php
 //exit('23423423424');  // content ở đây
 ?>
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php the_content(); ?>

			<?php endwhile; // end of the loop. ?>
			<?php
			   if( $GLOBALS['schema_website']) {
				$schema_website = $GLOBALS['schema_website'];
				if( $GLOBALS['schema_list_products']) {
					$schema_list_products = $GLOBALS['schema_list_products'];
					foreach ($schema_list_products as $key => $value) {
						$schema_website['@graph'][]=$value;
					}
				}
				if(\is_array( $schema_website )){
					$output = WPSEO_Utils::format_json_encode( $schema_website );
					$output = \str_replace( "\n", \PHP_EOL . "\t", $output );
					$dfgdfgd = '<script type="application/ld+json">' . $output . '</script>';
					echo $dfgdfgd;
				}
			}
			?>
</div>

<?php do_action( 'flatsome_after_page' ); ?>
<?php get_footer(); ?>


