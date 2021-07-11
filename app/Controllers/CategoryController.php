<?php

namespace App\Controllers;
use App\Models\Category;

class CategoryController extends CoreController {

    /**
     * Liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $categories = Category::findAll();

        $this->show('category/list', ['categories' => $categories]);
    }


    public function addPost()
    {
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);

        $errorList = [];

        if(empty($name)){
            $errorList[] = 'Le nom est vide';
        }

        if(empty($subtitle)){
            $errorList[] = 'La description est vide';
        }

        if(empty($picture)){
            $errorList[] = 'L\'image est vide';
        }

        if($picture === false){
            $errorList[] = 'L\'URL d\'image est invalide';
        }

        if(empty($errorList)){
            $category = new Category();
            //! on met a jour les propriétés de l'instance 
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);
        
            if($category->save()){
                header('Location: /category/list');
            }else{
                $errorList[] = 'La sauvegarde a échoué';
            }
        }

        if(!empty($errorList)){
            $this->show('category/add', ['errorList' => $errorList]);
        }

    }
    /**
     * Ajout catégorie
     *
     * @return void
     */
    public function add()
    {
        $this->generateCSRFToken();

        $category = new Category();
        $this->show('category/add', ['category' => $category]);
    }

    /**
     * Modifier une Categorie
     *
     */
    public function update($categoryId)
    {
        $this->generateCSRFToken();
        $category =  Category::find($categoryId);
        $this->show('category/add', ['category' => $category]);

    }


    public function updatePost($categoryId)
    {
        global $router;

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);

        $category = Category::find($categoryId);

        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);

        if($category->save()){
            $url = $router->generate('category-list');
            header('Location: '.$url);
        } else {
            $errorList[] = 'La sauvegarde a échoué';
        }
    }

    public function delete($categoryId)
    {
        global $router;
        $category = Category::find($categoryId);

        if($category->delete()){
            $url = $router->generate('category-list');
            header('Location: '.$url);
        }
    }
}
