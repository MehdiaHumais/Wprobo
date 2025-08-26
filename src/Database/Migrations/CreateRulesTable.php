<?php
namespace WPRobo\QuantityRules\Database\Migrations;

class CreateRulesTable {
    public function sql( string $table ): string {
        return "CREATE TABLE {$table} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(190) NOT NULL,
            enabled TINYINT(1) NOT NULL DEFAULT 1,
            scope VARCHAR(20) NOT NULL,              -- product|category|global
            rule_type VARCHAR(20) NOT NULL,          -- min|max|step
            product_ids LONGTEXT NULL,               -- JSON
            category_ids LONGTEXT NULL,              -- JSON
            min_qty BIGINT NULL,
            max_qty BIGINT NULL,
            step_qty BIGINT NULL,
            priority INT NOT NULL DEFAULT 0,         -- larger = higher priority
            date_start DATETIME NULL,
            date_end DATETIME NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            PRIMARY KEY  (id)
        ) %s;";
    }
}
