<?php
/**
 * Admin page template.
 *
 * @package DisableGutenbergForWP
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Separate built-in and custom post types.
$builtin_post_types = array();
$custom_post_types  = array();

foreach ( $post_types as $post_type ) {
	if ( $post_type->_builtin ) {
		$builtin_post_types[] = $post_type;
	} else {
		$custom_post_types[] = $post_type;
	}
}
?>

<div class="wrap dgwp-admin-wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="dgwp-admin-container">
		<div class="dgwp-admin-content">
			<div class="dgwp-card">
				<div class="dgwp-card-header">
					<h2><?php esc_html_e( 'Configure Post Types', 'disable-gutenberg-for-wp' ); ?></h2>
					<p class="description">
						<?php esc_html_e( 'Select the post types where you want to disable the Gutenberg block editor. The Classic Editor will be used for the selected post types.', 'disable-gutenberg-for-wp' ); ?>
					</p>
				</div>

				<form method="post" action="options.php">
					<?php
					settings_fields( 'dgwp_settings_group' );
					?>

					<div class="dgwp-card-body">
						<?php if ( ! empty( $post_types ) ) : ?>
							<div class="dgwp-bulk-actions">
								<button type="button" id="dgwp-select-all" class="button">
									<?php esc_html_e( 'Select All', 'disable-gutenberg-for-wp' ); ?>
								</button>
								<button type="button" id="dgwp-deselect-all" class="button">
									<?php esc_html_e( 'Deselect All', 'disable-gutenberg-for-wp' ); ?>
								</button>
							</div>

							<?php if ( ! empty( $builtin_post_types ) ) : ?>
								<div class="dgwp-post-types-section">
									<h3 class="dgwp-section-title"><?php esc_html_e( 'Built-in Post Types', 'disable-gutenberg-for-wp' ); ?></h3>
									<div class="dgwp-post-types-list">
										<?php foreach ( $builtin_post_types as $post_type ) : ?>
											<div class="dgwp-post-type-item">
												<label class="dgwp-toggle-label">
													<input
														type="checkbox"
														name="<?php echo esc_attr( $this->option_name ); ?>[]"
														value="<?php echo esc_attr( $post_type->name ); ?>"
														<?php checked( in_array( $post_type->name, $disabled_post_types, true ) ); ?>
														class="dgwp-toggle-checkbox"
													/>
													<span class="dgwp-toggle-switch"></span>
													<span class="dgwp-toggle-text">
														<strong><?php echo esc_html( $post_type->label ); ?></strong>
														<span class="dgwp-post-type-name"><?php echo esc_html( $post_type->name ); ?></span>
													</span>
												</label>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $custom_post_types ) ) : ?>
								<div class="dgwp-post-types-section">
									<h3 class="dgwp-section-title"><?php esc_html_e( 'Custom Post Types', 'disable-gutenberg-for-wp' ); ?></h3>
									<div class="dgwp-post-types-list">
										<?php foreach ( $custom_post_types as $post_type ) : ?>
											<div class="dgwp-post-type-item">
												<label class="dgwp-toggle-label">
													<input
														type="checkbox"
														name="<?php echo esc_attr( $this->option_name ); ?>[]"
														value="<?php echo esc_attr( $post_type->name ); ?>"
														<?php checked( in_array( $post_type->name, $disabled_post_types, true ) ); ?>
														class="dgwp-toggle-checkbox"
													/>
													<span class="dgwp-toggle-switch"></span>
													<span class="dgwp-toggle-text">
														<strong><?php echo esc_html( $post_type->label ); ?></strong>
														<span class="dgwp-post-type-name"><?php echo esc_html( $post_type->name ); ?></span>
													</span>
												</label>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php else : ?>
							<p class="dgwp-no-post-types">
								<?php esc_html_e( 'No public post types found.', 'disable-gutenberg-for-wp' ); ?>
							</p>
						<?php endif; ?>
					</div>

					<div class="dgwp-card-footer">
						<div class="dgwp-footer-actions">
							<?php submit_button( __( 'Save Changes', 'disable-gutenberg-for-wp' ), 'primary', 'submit', false ); ?>
						</div>
						<p class="description">
							<?php esc_html_e( 'Note: The Media (attachment) post type is excluded by default.', 'disable-gutenberg-for-wp' ); ?>
						</p>
					</div>
				</form>

				<form method="post" action="" class="dgwp-reset-form">
					<?php wp_nonce_field( 'dgwp_reset_settings', 'dgwp_reset_nonce' ); ?>
					<div class="dgwp-card-footer dgwp-danger-zone">
						<h3><?php esc_html_e( 'Reset Settings', 'disable-gutenberg-for-wp' ); ?></h3>
						<p class="description">
							<?php esc_html_e( 'This will reset all settings to defaults and enable Gutenberg for all post types.', 'disable-gutenberg-for-wp' ); ?>
						</p>
						<button type="submit" name="dgwp_reset_settings" class="button button-secondary dgwp-reset-button" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to reset all settings? This cannot be undone.', 'disable-gutenberg-for-wp' ); ?>');">
							<?php esc_html_e( 'Reset to Defaults', 'disable-gutenberg-for-wp' ); ?>
						</button>
					</div>
				</form>
			</div>
		</div>

		<div class="dgwp-admin-sidebar">
			<div class="dgwp-card">
				<div class="dgwp-card-header">
					<h3><?php esc_html_e( 'About This Plugin', 'disable-gutenberg-for-wp' ); ?></h3>
				</div>
				<div class="dgwp-card-body">
					<p><?php esc_html_e( 'This plugin allows you to selectively disable the Gutenberg block editor for specific post types while keeping it enabled for others.', 'disable-gutenberg-for-wp' ); ?></p>
					<ul class="dgwp-feature-list">
						<li><?php esc_html_e( 'Simple toggle-based interface', 'disable-gutenberg-for-wp' ); ?></li>
						<li><?php esc_html_e( 'No coding required', 'disable-gutenberg-for-wp' ); ?></li>
						<li><?php esc_html_e( 'Works with custom post types', 'disable-gutenberg-for-wp' ); ?></li>
						<li><?php esc_html_e( 'Lightweight and fast', 'disable-gutenberg-for-wp' ); ?></li>
					</ul>
				</div>
			</div>

			<div class="dgwp-card">
				<div class="dgwp-card-header">
					<h3><?php esc_html_e( 'Need Help?', 'disable-gutenberg-for-wp' ); ?></h3>
				</div>
				<div class="dgwp-card-body">
					<p>
						<?php
						printf(
							/* translators: %s: GitHub repository URL */
							esc_html__( 'If you encounter any issues or have questions, please visit our %s.', 'disable-gutenberg-for-wp' ),
							'<a href="https://github.com/Open-WP-Club/disable-gutenberg-for-wp" target="_blank" rel="noopener noreferrer">' . esc_html__( 'GitHub repository', 'disable-gutenberg-for-wp' ) . '</a>'
						);
						?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
