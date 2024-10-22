<?php

declare(strict_types=1);

namespace App\Models;

class Book extends Product
{

    private $weight;

    public function __construct($sku, $name, $price, $type, $weight)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->setWeight($weight);
    }

    /**
     * Set the value of weight
     *
     * @return  self
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of weight
     */
    public function getWeight()
    {

        return $this->weight;
    }

    function save()
    {
        try {
            $this->db->beginTransaction();
            $productStmt  = $this->db
                ->prepare(
                    "INSERT INTO products (sku,name,price,type,weight,created_at)
                 VALUES
                 (:sku,:name,:price,:type,:weight,:created_at)"
                );
            $productStmt->execute([
                ':sku' => $this->sku,
                ':name' => $this->name,
                ':price' => $this->price,
                ':type' => $this->type,
                ':weight' => $this->weight,
                ':created_at' => date('Y-m-d H:i:s', time()),
            ]);
            $this->db->commit();
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }
    function display()
    {
        return [
            'id' => $this->getId(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'specs' => 'Weight: ' . $this->getWeight() . ' KG'
        ];
    }
}
