<?php

declare(strict_types=1);

namespace App\Requests;

use App\Models\ProductFactory;

class ProductStoreRequest
{
    public static $errors = [];
    public static $required = 'Please, submit required data';
    public static $invalid = 'Please, provide the data of indicated type';
    public static $unique = 'This value already exists';

    public static function validate(array $request): void
    {
        $rules = [
            "sku" => ['required', 'alphaNumeric', 'unique'],
            "name" => ['required', 'alphaNumeric'],
            "price" => ['required', 'numeric'],
            "type" => ['required'],
            "size" => ['required', 'numeric'],
            "weight" => ['required', 'numeric'],
            "length" => ['required', 'numeric'],
            "width" => ['required', 'numeric'],
            "height" => ['required', 'numeric'],
        ];

        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                if (isset($request[$field])) {
                    self::validationMap($field, $rule, $request[$field]);
                }
            }
        }
    }

    public static function validationMap($field, $rule, $value): void
    {
        $methodMap = [
            'required' => 'validateRequired',
            'unique' => 'validateUnique',
            'alpha' => 'validateAlpha',
            'numeric' => 'validateNumeric',
            'alphaNumeric' => 'validateAlphaNumeric',
        ];

        if (array_key_exists($rule, $methodMap)) {
            call_user_func([self::class, $methodMap[$rule]], $value, $field);
        }
    }

    public static function validateRequired($value, $field): void
    {
        $specialFields = ['size', 'weight', 'length', 'width', 'height'];

        if (isset($field) && empty($value)) {

            if (in_array($field, $specialFields)) {
                self::$errors[$field]['required'] = "Please, provide $field";
            } else {
                self::$errors[$field]['required'] = self::$required;
            }
        }
    }

    public static function validateAlpha($value, $field): void
    {
        if (!preg_match('/^[a-zA-Z]+( [a-zA-Z]+)*$/', $value)) {
            self::$errors[$field]['alpha'] = self::$invalid;
        }
    }

    public static function validateNumeric($value, $field): void
    {
        if (!is_numeric(trim($value) ) || $value < 0) {
            self::$errors[$field]['numeric'] = self::$invalid;
        }
    }

    public static function validateAlphaNumeric($value, $field): void
    {
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d|[a-zA-Z])[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$|^[a-zA-Z]+$/', $value)) {
            self::$errors[$field]['alphaNumeric'] = self::$invalid;
        }
    }

    public static function validateUnique($value, $field): void
    {
        $product = new ProductFactory();
        if ($product->exists($value)) {
            self::$errors[$field]['exists'] = self::$unique;
        }
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }
}
