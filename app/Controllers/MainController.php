<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController {

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        $categories = Category::findThreeCategories();
      
        $products = Product::findThreeProducts();

        $tatayoyo = [
            'categories' => $categories,
            'products' => $products 
        ];
        
        $this->show('main/home', $tatayoyo);
    }
}
