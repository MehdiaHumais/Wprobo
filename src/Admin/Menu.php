<?php
namespace WPRobo\QuantityRules\Admin;

class Menu {
    public function register(): void {
        add_action('admin_menu', function () {
            add_menu_page(
                __('Quantity Rules', 'wprobo-quantity-rules'),
                __('Quantity Rules', 'wprobo-quantity-rules'),
                'manage_woocommerce',
                'wprqr-rules',
                [$this, 'renderRulesList'],
                'dashicons-editor-ol',
                56
            );

            add_submenu_page(
                'wprqr-rules',
                __('Add Rule', 'wprobo-quantity-rules'),
                __('Add New', 'wprobo-quantity-rules'),
                'manage_woocommerce',
                'wprqr-rule-edit',
                [$this, 'renderRuleEdit']
            );

            add_submenu_page(
                'wprqr-rules',
                __('Settings', 'wprobo-quantity-rules'),
                __('Settings', 'wprobo-quantity-rules'),
                'manage_woocommerce',
                'wprqr-settings',
                [$this, 'renderSettings']
            );
        });
    }

    public function renderRulesList(): void {
        require WPRQR_DIR . 'templates/admin/rule-list.php';
    }

    public function renderRuleEdit(): void {
        require WPRQR_DIR . 'templates/admin/rule-edit.php';
    }

    public function renderSettings(): void {
        require WPRQR_DIR . 'templates/admin/settings-page.php';
    }
}
