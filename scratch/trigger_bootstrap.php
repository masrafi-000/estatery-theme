<?php
/**
 * Script to force page creation bootstrap
 */

// Load WordPress
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');

use Estatery\Core\ThemeSetup;

// Flush the transient that prevents multiple runs
delete_transient('estatery_page_check_ran');

// Call the bootstrap method
ThemeSetup::bootstrap();

echo "Page bootstrap triggered successfully. Checked for 'blog' page creation.";
