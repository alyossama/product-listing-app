<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Configs\View;
use App\Models\ProductFactory;
use App\Requests\ProductStoreRequest;

class ProductController
{
    /**
     * Gets all products
     *
     * @return View
     */
    public function index(): View
    {
        $productFactory = new ProductFactory();
        $products = $productFactory->all();

        return View::make(
            'products/index',
            [
                'products' => $products
            ],
            'Home Page'
        );
    }

    /**
     * Add new product form
     *
     * @return View
     */
    public function create(): View
    {
        return View::make('products/create', [], 'Add new product');
    }

    public function store()
    {
        ProductStoreRequest::validate($_POST);
        $validationErrors = ProductStoreRequest::getErrors();
        $firstErrors = [];

        foreach ($validationErrors as $field => $errors) {
            if (is_array($errors) && !empty($errors)) {
                $firstErrors[$field] = reset($errors);
            }
        }

        $response = [];

        if (!empty($firstErrors)) {
            $response['errors'] = $firstErrors;
            echo json_encode($response);
            return;
        }

        $specs = [
            'dvd' => [$_POST['size']  ?? null],
            'book' => [$_POST['weight'] ?? null],
            'furniture' =>
            [
                $_POST['length'] ?? null,
                $_POST['width'] ?? null,
                $_POST['height'] ?? null,
            ],
        ];

        $product = ProductFactory::createProduct(
            $_POST['sku'],
            $_POST['name'],
            $_POST['price'],
            $_POST['type'],
            $specs[$_POST['type']]
        );

        $product->save();

        $response['success'] = "Product added successfully!";
        $response['product'] = $product;
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function delete()
    {
        if (!isset($_POST['product-delete']) ||  count($_POST['product-delete']) < 0) {
            return header('location: /');
        }

        $product = new ProductFactory();
        $product->remove($_POST['product-delete']);

        return header('location: /');
    }
}
