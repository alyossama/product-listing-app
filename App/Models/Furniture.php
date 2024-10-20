<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\GeneralTrait;

class Furniture extends Product
{
    use GeneralTrait;
    private $length;
    private $width;
    private $height;

    public function __construct($sku, $name, $price, $type, $length, $width, $height)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->setLength($length);
        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * Get the value of length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set the value of length
     *
     * @return  self
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get the value of width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of width
     *
     * @return  self
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the value of height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of height
     *
     * @return  self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    function save()
    {
        try {
            $this->db->beginTransaction();
            $productStmt  = $this->db
                ->prepare(
                    "INSERT INTO products (sku,name,price,type,length,width,height,created_at)
                                VALUES
                            (:sku,:name,:price,:type,:length,:width,:height,:created_at)"
                );
            $productStmt->execute([
                ':sku' => $this->sku,
                ':name' => $this->name,
                ':price' => $this->price,
                ':type' => $this->type,
                ':length' => $this->length,
                ':width' => $this->width,
                ':height' => $this->height,
                ':created_at' => date('Y-m-d H:i:s', time()),
            ]);
            $productStmt->execute();
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
            'specs' => 'Dimensions:' . $this->getLength() . 'x' . $this->getWidth() . 'x' . $this->getHeight()
        ];
    }
}
