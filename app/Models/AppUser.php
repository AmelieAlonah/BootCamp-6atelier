<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel {


  private $email;
  private $password;
  private $firstname;
  private $lastname;
  private $role;
  private $status;

  public static function findByEmail($email)
  {
    $pdo = Database::getPDO();

    $sql = '
      SELECT *
      FROM `app_user`
      WHERE email = :email
    ';

    $pdoStatement = $pdo->prepare($sql);

    $pdoStatement->bindValue(':email', $email);
    $pdoStatement->execute();
    $result = $pdoStatement->fetchObject(self::class);

    return $result;

  }


  /**
   * Méthode permettant la récupération d'un model en base
   */
  public static function find($userId)
  {
      // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
  }

  /**
   * Méthode permettant la récupération de tous les models en base
   */
  public static function findAll()
  {
    $pdo = Database::getPDO();
    $sql = 'SELECT * FROM `app_user`';
    $pdoStatement = $pdo->query($sql);
    $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
    
    return $results;
  }

      /**
   * Méthode permettant la création du model en base
   */
  public function insert()
  {
    $pdo = Database::getPDO();

    $sql = "
        INSERT INTO `app_user` (
          `email`, 
          `password`, 
          `firstname`,
          `lastname`,
          `role`,
          `status`
          )
        VALUES (
          :email, 
          :password, 
          :firstname,
          :lastname,
          :role,
          :status
          )
    ";

    $pdoStatement   = $pdo->prepare($sql);
    $success        = $pdoStatement->execute([
      ':email'      => $this->email,
      ':password'   => $this->password,
      ':firstname'  => $this->firstname,
      ':lastname'   => $this->lastname,
      ':role'       => $this->role,
      ':status'     => $this->status,
    ]);

    if($success){
      $this->id = $pdo->lastInsertId();
    }
    return true;
  }


  /**
   * Méthode permettant la mise à jour du model en base
   */
  public function update()
  {
      // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
  }

  /**
   * Méthode permettant la suppression du model en base
   */
  public function delete()
  {
      // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
  }

  /**
   * Get the value of email
   */ 
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */ 
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   */ 
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */ 
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of firstname
   */ 
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstname
   *
   * @return  self
   */ 
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get the value of lastname
   */ 
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   *
   * @return  self
   */ 
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;

    return $this;
  }
  /**
   * Get the value of status
   */ 
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Set the value of status
   *
   * @return  self
   */ 
  public function setStatus($status)
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Get the value of role
   */ 
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   *
   * @return  self
   */ 
  public function setRole($role)
  {
    $this->role = $role;

    return $this;
  }
}