<?php

namespace App;

use App\Helpers\Tools;
use App\Helpers\Mail;
use App\Helpers\Db;
use App\Hashids\Hashids;

class User extends ObjectModel
{

    protected $table = 'users';
    protected $rules = [ 'email' => 'required' , 'password' => 'required' , 'first_name' => 'required' , 'last_name' => 'required' ];
    protected $fillable = ['email', 'password', 'first_name', 'last_name', 'address_1', 'address_2', 'phone', 'town', 'postcode', 'country' ];
    protected $db;
    protected $unique_id;
    protected $user_id = false;
		
			
    public function __construct(Db $db)
    {

	$this->db = $db;

    }
    
    
    public function setRules(array $rules)
    {

	$this->rules = $rules;

    }
    
    
    public function setUserId(int $user_id)
    {
	
	$this->user_id = $user_id;

    }


    public function setUniqueId(string $unique_id)
    {

	$this->unique_id = $unique_id;

    }


    public function getUniqueId(): string
    {
	
	return $this->unique_id;

    }
    
    
    public function add(array $request): ?object
    {

	$insert_id = $this->create( $request );
	
		if( ! is_numeric($insert_id) ){

			return NULL;
		
		}
		
	return $this->find($insert_id);

    }
    
    
    public function updateUser(int $user_id, array $request): object
    {

	$this->update($request, 'id = :id', ['id' => $user_id]);

	return $this->find($user_id);

    }
    

    public function auth(): ?object
    {

	if( ! $this->user_id ){
	
		return NULL;
	
	} else {
	
		return $this->find($this->user_id);				
	
	}

    }




    public function login(string $email, string $password, int $role): ?object
    {

	
	$result = $this->execute(' SELECT * FROM users WHERE 
						email = ? AND user_role_id = ? AND password IS NOT NULL 
						AND deleted_at IS NULL ', [ $email, $role ]);
	
	if( ! count( $result ) ){
	
		return NULL;
	
	} else {
	
		if( ! password_verify($password, $result[0]->password) ){
		
			return NULL;
		
		}
	
		return $result[0]; 
	
	}


    }






}
