<?php
/**
 * The template to display the Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}



// Callback for output single comment layout
if ( ! function_exists( 'rareradio_output_single_comment' ) ) {
	function rareradio_output_single_comment( $comment, $args, $depth ) {
		switch ( $comment->comment_type ) {
			case 'pingback':
				?>
				<li class="trackback"><?php esc_html_e( 'Trackback:', 'rareradio' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'rareradio' ), '<span class="edit-link">', '<span>' ); ?>
				<?php
				break;
			case 'trackback':
				?>
				<li class="pingback"><?php esc_html_e( 'Pingback:', 'rareradio' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'rareradio' ), '<span class="edit-link">', '<span>' ); ?>
				<?php
				break;
			default:
				$author_id   = $comment->user_id;
				$author_link = ! empty( $author_id ) ? get_author_posts_url( $author_id ) : '';
				$mult        = rareradio_get_retina_multiplier();
				$comment_id  = get_comment_ID();
				?>
				<li id="comment-<?php echo esc_attr( $comment_id ); ?>" <?php comment_class( 'comment_item' ); ?>>
					<div id="comment_body-<?php echo esc_attr( $comment_id ); ?>" class="comment_body">
						<div class="comment_author_avatar"><?php echo get_avatar( $comment, 240 * $mult ); ?></div>
						<div class="comment_content">
							<div class="comment_info">
								<h6 class="comment_author">
								<span><?php echo esc_html__('by', 'rareradio'); ?></span>
								<?php
									echo ( ! empty( $author_link ) ? '<a href="' . esc_url( $author_link ) . '">' : '' )
											. esc_html( get_comment_author() )
											. ( ! empty( $author_link ) ? '</a>' : '' );
								?>
								</h6>
								<div class="comment_posted">
									<span class="comment_posted_label"><?php esc_html_e( 'Posted', 'rareradio' ); ?></span>
									<span class="comment_date">
									<?php
										echo esc_html( get_comment_date( get_option( 'date_format' ) ) );  
									?>
									</span>
								</div>
								<?php
								if ( $depth < $args['max_depth'] ) {
									?>
									<div class="reply comment_reply">
									<?php
										comment_reply_link(
											array_merge(
												$args, array(
													'add_below' => 'comment_body',
													'depth' => $depth,
													'max_depth' => $args['max_depth'],
												)
											)
										);
									?>
									</div>
									<?php
								}
								// Show rating in the comment
								do_action( 'trx_addons_action_post_rating', 'c' . esc_attr( $comment_id ) );
								?>
							</div>
							<div class="comment_text_wrap">
								<?php if ( 0 == $comment->comment_approved ) { ?>
								<div class="comment_not_approved"><?php esc_html_e( 'Your comment is awaiting moderation.', 'rareradio' ); ?></div>
								<?php } ?>
								<div class="comment_text"><?php comment_text(); ?></div>
							</div>
							<?php
							
							?>
						</div>
					</div>
				<?php
				break;
		}
	}
}


// Output comments list
if ( have_comments() || comments_open() ) {
	?>
	<section class="comments_wrap">
		<?php
		if ( have_comments() ) {
			?>
			<div id="comments" class="comments_list_wrap">
				<h3 class="section_title comments_list_title">
				<?php
				$rareradio_post_comments = get_comments_number();
				echo esc_html( $rareradio_post_comments );
				?>
			<?php echo esc_html( _n( 'Comment', 'Comments', $rareradio_post_comments, 'rareradio' ) ); ?></h3>
				<ul class="comments_list">
					<?php
					wp_list_comments( array( 'callback' => 'rareradio_output_single_comment' ) );
					?>
				</ul><!-- .comments_list -->
					<?php
					if ( ! comments_open() && get_comments_number() != 0 && post_type_supports( get_post_type(), 'comments' ) ) {
						?>
					<p class="comments_closed"><?php esc_html_e( 'Comments are closed.', 'rareradio' ); ?></p>
						<?php
					}
					if ( get_comment_pages_count() > 1 ) {
						?>
					<div class="comments_pagination"><?php paginate_comments_links(); ?></div>
						<?php
					}
					?>
			</div><!-- .comments_list_wrap -->
				<?php
		}

		if ( comments_open() ) {
			?>
			<div class="comments_form_wrap">
				<div class="comments_form">
				<?php
				$rareradio_form_style = esc_attr( rareradio_get_theme_option( 'input_hover' ) );
				if ( empty( $rareradio_form_style ) || rareradio_is_inherit( $rareradio_form_style ) ) {
					$rareradio_form_style = 'default';
				}
				$rareradio_commenter     = wp_get_current_commenter();
				$rareradio_req           = get_option( 'require_name_email' );
				$rareradio_comments_args = apply_filters(
					'rareradio_filter_comment_form_args', array(
						// class of the 'form' tag
						'class_form'           => 'comment-form ' . ( 'default' != $rareradio_form_style ? 'sc_input_hover_' . esc_attr( $rareradio_form_style ) : '' ),
						// change the id of send button
						'id_submit'            => 'send_comment',
						// change the title of send button
						'label_submit'         => esc_html__( 'Submit', 'rareradio' ),
						// change the title of the reply section
						'title_reply'          => esc_html__( 'Add Your Comment', 'rareradio' ),
						'title_reply_before'   => '<h3 class="section_title comments_form_title">',
						'title_reply_after'    => '</h3>',
						// remove "Logged in as"
						'logged_in_as'         => '',
						// remove text before textarea
						'comment_notes_before' => '',
						// remove text after textarea
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => rareradio_single_comments_field(
								array(
									'form_style'        => $rareradio_form_style,
									'field_type'        => 'text',
									'field_req'         => $rareradio_req,
									'field_icon'        => 'icon-user',
									'field_value'       => isset( $rareradio_commenter['comment_author'] ) ? $rareradio_commenter['comment_author'] : '',
									'field_name'        => 'author',
									'field_title'       => esc_attr__( 'Name', 'rareradio' ),
									'field_placeholder' => esc_attr__( 'Your Name', 'rareradio' ),
								)
							),
							'email'  => rareradio_single_comments_field(
								array(
									'form_style'        => $rareradio_form_style,
									'field_type'        => 'text',
									'field_req'         => $rareradio_req,
									'field_icon'        => 'icon-mail',
									'field_value'       => isset( $rareradio_commenter['comment_author_email'] ) ? $rareradio_commenter['comment_author_email'] : '',
									'field_name'        => 'email',
									'field_title'       => esc_attr__( 'E-mail', 'rareradio' ),
									'field_placeholder' => esc_attr__( 'Your E-mail', 'rareradio' ),
								)
							),
						),
						// redefine your own textarea (the comment body)
						'comment_field'        => rareradio_single_comments_field(
							array(
								'form_style'        => $rareradio_form_style,
								'field_type'        => 'textarea',
								'field_req'         => true,
								'field_icon'        => 'icon-feather',
								'field_value'       => '',
								'field_name'        => 'comment',
								'field_title'       => esc_attr__( 'Comment', 'rareradio' ),
								'field_placeholder' => esc_attr__( 'Your comment', 'rareradio' ),
							)
						),
					)
				);
				comment_form( $rareradio_comments_args );
				?>
				</div>
			</div><!-- /.comments_form_wrap -->
			<?php
		}
		?>
	</section><!-- /.comments_wrap -->
	<?php
}
