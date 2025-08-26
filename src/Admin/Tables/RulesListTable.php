<?php
namespace WPRobo\QuantityRules\Admin\Tables;

use WP_List_Table;
use WPRobo\QuantityRules\Domain\Repositories\RuleRepository;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class RulesListTable extends WP_List_Table {
    private RuleRepository $repo;

    public function __construct(RuleRepository $repo) {
        parent::__construct([
            'singular' => 'rule',
            'plural'   => 'rules',
            'ajax'     => false
        ]);
        $this->repo = $repo;
    }

    public function get_columns() {
        return [
            'cb'        => '<input type="checkbox" />',
            'name'      => __('Name', 'wprobo-quantity-rules'),
            'scope'     => __('Scope', 'wprobo-quantity-rules'),
            'rule_type' => __('Type', 'wprobo-quantity-rules'),
            'priority'  => __('Priority', 'wprobo-quantity-rules'),
            'enabled'   => __('Enabled', 'wprobo-quantity-rules'),
        ];
    }

    public function prepare_items() {
        $this->items = $this->repo->all();
        $this->_column_headers = [$this->get_columns(), [], []];
    }

    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'scope':
            case 'rule_type':
            case 'priority':
                return esc_html($item->$column_name);
            case 'enabled':
                return $item->enabled ? '✅' : '❌';
            default:
                return esc_html($item->$column_name ?? '');
        }
    }

    public function column_cb($item) {
        return sprintf('<input type="checkbox" name="rule_ids[]" value="%d" />', $item->id);
    }

    public function column_name($item) {
        $edit_link = admin_url("admin.php?page=wprqr-rule-edit&rule_id={$item->id}");
        return sprintf('<a href="%s">%s</a>', esc_url($edit_link), esc_html($item->name));
    }
}
