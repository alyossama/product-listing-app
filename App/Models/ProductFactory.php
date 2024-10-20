<?php

declare(strict_types=1);

namespace App\Models;

class ProductFactory extends Model
{
    public static function createProduct($sku,  $name, $price, $type, $specs)
    {
        $classMap = [
            'dvd' => DVD::class,
            'book' => Book::class,
            'furniture' => Furniture::class,
        ];

        return new $classMap[$type]($sku, $name, $price, $type, ...$specs);
    }

    public function exists($sku): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM products WHERE sku = :sku");
        $stmt->execute([':sku' => $sku]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function all()
    {
        $stmt = $this->db->prepare('SELECT * FROM products');
        $stmt->execute();
        $result = $stmt->fetchAll();

        $classMap = [
            'dvd' => DVD::class,
            'book' => Book::class,
            'furniture' => Furniture::class,
        ];

        $products = [];
        foreach ($result as $product) {
            $specs = [
                'dvd' => [$product['size']  ?? null],
                'book' => [$product['weight'] ?? null],
                'furniture' =>
                [
                    $product['length'] ?? null,
                    $product['width'] ?? null,
                    $product['height'] ?? null,
                ],
            ];

            $productObj = new $classMap[$product['type']](
                $product['sku'],
                $product['name'],
                $product['price'],
                $product['type'],
                ...$specs[$product['type']]
            );

            $productObj->setId($product['id']);
            $display = $productObj->display();
            $products[] = $display;
        }

        return $products;
    }

    public function remove($ids)
    {
        $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
        $stmt = $this->db->prepare("DELETE FROM products WHERE id IN ($placeholders)");

        return $stmt->execute($ids);
    }
}
