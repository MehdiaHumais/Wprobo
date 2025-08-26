<?php
namespace WPRobo\QuantityRules\Domain\Entities;

class Rule {
    public int $id;
    public string $name;
    public string $scope;      // product|category|global
    public string $rule_type;  // min|max|step
    public ?array $product_ids = [];
    public ?array $category_ids = [];
    public ?int $min_qty = null;
    public ?int $max_qty = null;
    public ?int $step_qty = null;
    public int $priority = 0;
    public bool $enabled = true;
    public ?string $date_start = null;
    public ?string $date_end = null;

    public function __construct(array $data = []) {
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }
}
