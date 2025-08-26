<?php
namespace WPRobo\QuantityRules;

class Plugin {
    public function boot(): void {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p>✅ Plugin loaded from src/Plugin.php</p></div>';
        });
    }
}
