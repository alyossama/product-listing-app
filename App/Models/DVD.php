<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\GeneralTrait;

class DVD extends Product
{
    use GeneralTrait;

    private $size;

    public function __construct($sku, $name, $price, $type, $size)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->setSize($size);
    }

    /**
     * Set the value of size
     *
     * @return  self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the value of size
     */
    public function getSize()
    {
        return "Size: $this->size MB";
    }

    function save()
    {
        try {
            $this->db->beginTransaction();
            $productStmt  = $this->db->prepare("INSERT INTO products (sku,name,price,type,size,created_at) VALUES(:sku,:name,:price,:type,:size,:created_at)");
            $productStmt->execute([
                ':sku' => $this->sku,
                ':name' => $this->name,
                ':price' => $this->price,
                ':type' => $this->type,
                ':size' => $this->size,
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
            'specs' => $this->getSize(),
        ];
    }
}
