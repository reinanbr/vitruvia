<?php

use Vitruvia\Core\Models\Model;

class LibsModel extends Model
{
    public string $name;
    public string $keyLib;

    public function rules(): array
    {
        return [
            "name" => [self::RULE_REQUIRED],
            "keyLib" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 20]],
        ];
    }
}
