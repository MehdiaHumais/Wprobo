<?php
namespace WPRobo\QuantityRules\Domain\Repositories;

use WPRobo\QuantityRules\Domain\Entities\Rule;
use wpdb;

class RuleRepository {
    private wpdb $db;
    private string $table;

    public function __construct(\wpdb $db) {
        $this->db = $db;
        $this->table = $db->prefix . 'wprqr_rules';
    }

    public function all(): array {
        $rows = $this->db->get_results("SELECT * FROM {$this->table} ORDER BY priority DESC", ARRAY_A);
        return array_map(fn($row) => new Rule($this->unserializeFields($row)), $rows);
    }

    public function find(int $id): ?Rule {
        $row = $this->db->get_row($this->db->prepare("SELECT * FROM {$this->table} WHERE id=%d", $id), ARRAY_A);
        return $row ? new Rule($this->unserializeFields($row)) : null;
    }

    public function create(array $data): int {
        $data = $this->serializeFields($data);
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id;
    }

    public function update(int $id, array $data): bool {
        $data = $this->serializeFields($data);
        return (bool) $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete(int $id): bool {
        return (bool) $this->db->delete($this->table, ['id' => $id]);
    }

    private function serializeFields(array $data): array {
        if (isset($data['product_ids'])) $data['product_ids'] = maybe_serialize($data['product_ids']);
        if (isset($data['category_ids'])) $data['category_ids'] = maybe_serialize($data['category_ids']);
        return $data;
    }

    private function unserializeFields(array $data): array {
        if (isset($data['product_ids'])) $data['product_ids'] = maybe_unserialize($data['product_ids']);
        if (isset($data['category_ids'])) $data['category_ids'] = maybe_unserialize($data['category_ids']);
        return $data;
    }
}
