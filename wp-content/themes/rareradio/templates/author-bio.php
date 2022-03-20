<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */
?>

<div class="author_info scheme_dark author vcard" itemprop="author" itemscope itemtype="//schema.org/Person">
	<div class="author_avatar_wrap">
		<div class="author_avatar" itemprop="image">
			<?php
			$rareradio_mult = rareradio_get_retina_multiplier();
			echo get_avatar( get_the_author_meta( 'user_email' ), 370 * $rareradio_mult );
			?>
		</div><!-- .author_avatar -->
	</div>
	<div class="author_description">
		<h5 class="author_title" itemprop="name">
		<?php
			// Translators: Add the author's name in the <span>
			echo wp_kses_data( sprintf( __( 'About %s', 'rareradio' ), '<span class="fn">' . get_the_author() . '</span>' ) );
		?>
		</h5>

		<div class="author_bio" itemprop="description">
			<?php echo wp_kses( wpautop( get_the_author_meta( 'description' ) ), 'rareradio_kses_content' ); ?>
			<?php do_action( 'rareradio_action_user_meta' ); ?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
													<?php
													// Translators: Add the author's name in the <span>
													printf( esc_html__( 'View all posts by %s', 'rareradio' ), '<span class="author_name">' . esc_html( get_the_author() ) . '</span>' );
													?>
			</a>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->
