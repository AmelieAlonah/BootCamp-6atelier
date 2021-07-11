<?php

namespace App\Controllers;

abstract class CoreController {

    public function __construct()
    {
        //MAUVAISE PRATIQUE
        global $match;

        $routeName = $match['name'];

        $acl = [
            'main-home' => ['admin', 'catalog-manager'],
            'user-list' => ['admin'],
            'user-add' => ['admin'],
            'category-list' => ['admin'],
            'product-list' => ['catalog-manager']
            
        ];

        if(array_key_exists($routeName, $acl)){
            $authorizedRoles = $acl[$routeName];
            $this->checkAuthorization($authorizedRoles);
        }

        $csrfTokenToCheckInPost = [
            'user-addPost',
            'category-addPost'
        ];

        if(in_array($routeName, $csrfTokenToCheckInPost)){
            $this->checkCSRFToken();
        }
    }

    public function checkCSRFToken()
    {
        $postToken = filter_input(INPUT_POST, 'token');
        $sessionToken = $_SESSION['csrfToken'];

        if(empty($postToken) || empty($sessionToken) || $sessionToken != $postToken){
            http_response_code(403);
            $this->show('error/err403');
            exit();
        } 
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewVars Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewVars = []) {

        global $router;
        $viewVars['currentPage'] = $viewName; 

        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];
        extract($viewVars);

        require_once __DIR__.'/../views/layout/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/layout/footer.tpl.php';
    }

    protected function checkAuthorization($roles=[])
    {
        global $router;

        if(isset($_SESSION['userId'])){
            $currentUser = $_SESSION['userObject'];
            $currentUserRole = $currentUser->getRole();

            if(in_array($currentUserRole, $roles)) {
                return true;
            } else {
                http_response_code(403);
                $this->show('error/err403');
                exit();
            }
            

        } else {
            header('Location: ' . $router->generate('user-login'));
            exit();
        }
    }

    public function generateCSRFToken()
    {
        $bytes = random_bytes(5);
        $csrfToken = bin2hex($bytes);

        $_SESSION['csrfToken'] = $csrfToken;
        return $csrfToken;
    }
}




