<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Type;
use App\Models\Category;

class ProductController extends CoreController {

    /**
     * Liste des produits
     *
     * @return void
     */
    public function list()
    {
        $products = Product::findAll();
        $this->show('product/list', ['products' => $products]);
    }

    /**
     * Ajout produit
     *
     * @return void
     */
    public function add()
    {
        $product = new Product();

        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();

        $viewVars = [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types
        ];

        $this->show('product/add', $viewVars);
    }

    /**
     * Methode traitement du formulaire ajout produit
     *
     * @return void
     */
    public function addPost()  
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $brand_id = filter_input(INPUT_POST, 'brand_id',  FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);

        $errorList = [];

        if(empty($name)){
            $errorList[] = 'Le nom est vide';
        }

        if(empty($description)){
            $errorList[] = 'La description vide';
        }

        if(empty($picture)){
            $errorList[] = 'L\'image est vide';
        }

        if($picture === false){
            $errorList[] = 'L\'URL d\'image est invalide';
        }

        if ($price === false) {
            $errorList[] = 'Le prix est invalide';
        }
        if ($rate === false) {
            $errorList[] = 'La note est invalide';
        }
        if ($status === false) {
            $errorList[] = 'Le statut est invalide';
        }
        if ($brand_id === false) {
            $errorList[] = 'La marque est invalide';
        }
        if ($category_id === false) {
            $errorList[] = 'La catégorie est invalide';
        }
        if ($type_id === false) {
            $errorList[] = 'Le type est invalide';
        }

        if(empty($errorList)){
            $product = new Product();

            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setRate($rate);
            $product->setStatus($status);
            $product->setBrandId($brand_id);
            $product->setCategoryId($category_id);
            $product->setTypeId($type_id);

            if($product->insert()){
                header('Location: /product/list');
                exit;
            } else {
                $errorList[] = 'La sauvegarde a échoué';
            }

        }

        if(!empty($errorList)){
            $this->show('product/add', ['errorList' => $errorList]);
        }

    }

    /**
     * Update produit (page formulaire)
     *
     * @param [type] $productId
     * @return void
     */
    public function update($productId)
    {
        $product = Product::find($productId);
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();
        $viewVars = [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types
        ];
         
         $this->show('product/add', $viewVars);
    }

    /**
     * Update produit (traitement données forumlaire)
     */
    public function updatePost($productId)
    {
        global $router;

        $name = filter_input(INPUT_POST, 'name',  FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description',  FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL); 
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);

        $product = Product::find($productId);

        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setBrandId($brand_id);
        $product->setCategoryId($category_id);
        $product->setTypeId($type_id);

        if($product->save()){

            $url = $router->generate('product-list');
            header('Location: ' .$url);
        }
    }

    /**
     * Delete de produit 
     *
     * @param [type] $productId
     * @return void
     */
    public function delete($productId)
    {
        global $router;
  
        $product = Product::find($productId);

        if($product->delete()){
            $url = $router->generate('product-list');
            header('Location: ' . $url);
        }
    }
}
