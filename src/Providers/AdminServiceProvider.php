<?php
namespace WPRobo\QuantityRules\Providers;

use WPRobo\QuantityRules\Admin\Menu;

class AdminServiceProvider {
    public function register(): void {
        if (is_admin()) {
            (new Menu())->register();
        }
    }
}
