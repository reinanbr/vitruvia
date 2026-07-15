<?php

namespace Vitruvia\Core\Models;

abstract class Model
{
    public const RULE_REQUIRED = "required";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";
    public const RULE_BIT = "bit";

    public array $errors = [];

    public function loadData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute} ?? null;

            foreach ($rules as $rule) {
                $ruleName = is_string($rule) ? $rule : $rule[0];

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_MIN && strlen((string) $value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_MAX && strlen((string) $value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, ['max' => $rule['max']]);
                }
                if ($ruleName === self::RULE_MATCH && $value !== ($this->{$rule['match']} ?? null)) {
                    $this->addError($attribute, self::RULE_MATCH);
                }
            }
        }

        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? "This field is invalid ($rule)";
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", (string) $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function hasError(string $attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    public function firstError(string $attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }

    protected function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_MIN => "Min length of this field must be {min}",
            self::RULE_MAX => "Max length of this field must be {max}",
            self::RULE_MATCH => "This field must match another field",
        ];
    }

    abstract public function rules(): array;
}
