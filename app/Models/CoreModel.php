<?php

namespace App\Models;

abstract class CoreModel {
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    abstract static public function find($id);
    abstract static public function findAll();
    abstract public function insert();
    abstract public function update();
    abstract public function delete();

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */ 
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */ 
    public function getUpdatedAt() : string
    {
        if($this->updated_at !== null){
            return $this->updated_at;
        } else {
            return "vide !";
        }
        
    }

    public function save() 
    {
        if($this->id != null){
            return $this->update();
        } else {
            return $this->insert();
        }
    }
}
