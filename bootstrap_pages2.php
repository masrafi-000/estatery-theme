<?php
require_once '../../../wp-load.php';

// Clear the daily transient so ensure_pages_exist() runs immediately
delete_transient( \Estatery\Core\ThemeSetup::TRANSIENT_KEY );

\Estatery\Core\ThemeSetup::bootstrap();

echo "Bootstrapped completely.";
