<?php

require_once '../vendor/autoload.php';

session_start();

/* ------------
--- ROUTAGE ---
-------------*/

$router = new AltoRouter();

if (array_key_exists('BASE_URI', $_SERVER)) {
    $router->setBasePath($_SERVER['BASE_URI']);
}
else {
    $_SERVER['BASE_URI'] = '/';
}
// Page d'accueil
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);

//---------------------------------------------------------
//-------------------------- ROUTES CATGORIES --------------
// Liste des categories
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-list'
);

// Ajout categorie
$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add'
);

// Ajout categorie POST
$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-addPost'
);

// Update categorie
//! route dynamique 
$router->map(
    'GET',
    '/category/update/[i:id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-update'
);

// Update categorie post
//! route dynamique 
$router->map(
    'POST',
    '/category/update/[i:id]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-updatePost'
);

// Delete categorie
//! route dynamique 
$router->map(
    'GET',
    '/category/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-delete'
);

// Liste des produits
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

// Ajout produit
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);

$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-addPost'
);
// Update produit
//! route dynamique 
$router->map(
    'GET',
    '/product/update/[i:id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-update'
);
// Update Product post
//! route dynamique 
$router->map(
    'POST',
    '/product/update/[i:id]',
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-updatePost'
);
// Delete Product
//! route dynamique 
$router->map(
    'GET',
    '/product/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-delete'
);
// user Login, formulaire
$router->map(
    'GET',
    '/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-login'
);
// user login, traitement données du formulaire
$router->map(
    'POST',
    '/login',
    [
        'method' => 'loginPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-loginPost'
);
// user Logout
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-logout'
);

// Liste des utilisateurs
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-list'
);

// ajouter un utilisateur
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add'
);

// ajouter un utilisateur POST
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-addPost'
);

/* ------------
--- DISPATCH ---
--------------*/

$match = $router->match();
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
$dispatcher->dispatch();