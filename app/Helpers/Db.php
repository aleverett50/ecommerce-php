<?php

namespace App\Helpers;

use PDO;

class Db
{

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'hiddenwardrobe';
    
    public function setDatabase($database)
    {
    
	/* so we can change the db for unit testing */

	$this->database = $database;

    }

    public function conn()
    {

    $connect = false;

		$options = array(

			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

		);



	try{

	$connect = new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->username, $this->password, $options);

	} catch(PDOException $e){

	print $e->getMessage();

	}

    return $connect;

    }

}
