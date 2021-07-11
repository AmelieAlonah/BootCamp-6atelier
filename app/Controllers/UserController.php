<?php


namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController {

  public function login()
  {
    $this->show('user/login');
  }

  public function loginPost()
  {
    global $router;

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');

    $user = AppUser::findByEmail($email);

    if($user === false){
      exit('Utilisateur ou mot de passe incorrect');
    }

    if(password_verify($password, $user->getPassword())){
      
      $_SESSION['userObject'] = $user;
      $_SESSION['userId'] = $user->getId();
      header('Location: ' . $router->generate('main-home'));

    } else {
      exit('Utilisateur ou mot de passe incorrect');
    }
  }


  public function list()
  {

    $users = AppUser::findAll();

    $this->show('user/list', ['users' => $users]);
  }

  public function add()
  {
    $this->generateCSRFToken();
    $this->show('user/add');
  }

  public function addPost()
  {
    $this->checkAuthorization(['admin']);

    //TODO Mauvause pratique : 
    global $router;

    $errors = [];

    $email = filter_input(INPUT_POST, 'email' );
    $password = filter_input(INPUT_POST, 'password');
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname = filter_input(INPUT_POST, 'lastname');
    $role = filter_input(INPUT_POST, 'role');
    $status = filter_input(INPUT_POST, 'status');

    if(!$email || !$password || !$firstname || !$lastname || !$role || !$status){
      $errors[] = 'Tous les champs sont obligatoires';
    }

    $emailFilter = filter_var($email, FILTER_VALIDATE_EMAIL);
    if($emailFilter === false ){
      $errors[] = 'Le format de l\'email n\'est pas valide.';
    }

    if(strlen($password) < 8){
      $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }

    if(count($errors) > 0){
      exit();
    }

    /* --------------------
    -- ENREGISTREMENT --
    -------------------- */
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $newUser = new AppUser;
    $newUser->setEmail($email);
    $newUser->setPassword($hashedPassword);
    $newUser->setFirstname($firstname);
    $newUser->setLastname($lastname);
    $newUser->setRole($role);
    $newUser->setStatus($status);

    $newUser->save();

    header('Location: ' . $router->generate('user-list'));
    exit();
  }

  public function logout()
  {
    //TODO MAUVAISE PRATIQUE
    global $router;
    unset($_SESSION['userId']);
    unset($_SESSION['userObject']);
    header('Location: ' . $router->generate('user-login'));
  }

}
