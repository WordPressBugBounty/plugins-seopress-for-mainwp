<?php
/**
 * SEOPress Tabs Content
 *
 * @package SEOPress\MainWP
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check user capabilities
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'Insufficient permissions', 'wp-seopress-mainwp' ) );
}

// Define allowed tabs for security
$allowed_tabs = array(
	'seopress-dashboard',
	'seopress-titles',
	'seopress-xml-sitemap',
	'seopress-social',
	'seopress-google-analytics',
	'seopress-instant-indexing',
	'seopress-advanced',
	'seopress-import-export',
	'seopress-pro-page',
	'seopress-license',
);

// Validate current tab
if ( ! in_array( $this->current_tab, $allowed_tabs, true ) ) {
	wp_die( esc_html__( 'Invalid tab specified', 'wp-seopress-mainwp' ) );
}

// Sanitize the file path to prevent directory traversal
$view_file = SEOPRESS_WPMAIN_PLUGIN_DIR . 'views/' . $this->current_tab . '.php';
$view_file = realpath( $view_file );

// Additional security check to ensure file is within the views directory
$views_dir = realpath( SEOPRESS_WPMAIN_PLUGIN_DIR . 'views/' );
if ( ! $view_file || strpos( $view_file, $views_dir ) !== 0 ) {
	wp_die( esc_html__( 'Invalid file path', 'wp-seopress-mainwp' ) );
}
?>

<?php if ( 'seopress-import-export' !== $this->current_tab ) : ?>
	<div class="mainwp-main-content">
		<?php require_once $view_file; ?>
	</div>
	<div class="mainwp-side-content mainwp-no-padding">
		<div class="mainwp-select-sites">
			<div class="ui header"><?php esc_html_e( 'Select Sites', 'wp-seopress-mainwp' ); ?></div>
			<?php do_action( 'mainwp_select_sites_box', '', 'checkbox', true, true, '', '', $selected_websites, $selected_groups ); ?>
			<button type="button" class="ui button green" id="mainwp-seopress-apply-changes-button"><?php esc_html_e( 'Apply Changes', 'wp-seopress-mainwp' ); ?></button>
			<button type="button" class="ui button basic green" id="mainwp-seopress-load-settings-button"><?php esc_html_e( 'Load Settings', 'wp-seopress-mainwp' ); ?></button>
		</div>
	</div>
<?php else : ?>
	<?php require_once $view_file; ?>
<?php endif; ?>
<div class="ui hidden clearing divider"></div>
