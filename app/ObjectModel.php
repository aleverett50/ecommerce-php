<?php

namespace App;

use App\Helpers\Validation;
use App\Helpers\Tools;
use PDO;

abstract class ObjectModel
{

    protected $table;
    protected $db;
    protected $timestamps = true;
    protected $rules = array();
    protected $fillable = array();
    protected $unFillable = array();
    protected $dates = array();


    public function execute($query, array $array)
    {

	$query = $this->db->conn()->prepare($query);

	$query->execute($array);

	return $query->fetchAll(PDO::FETCH_OBJ);

    }


    public function find($id)
    {

	$query = $this->db->conn()->prepare('SELECT * FROM `' . $this->table . '` WHERE BINARY id = ?  ');

	$query->execute(array($id));

	return $query->fetch(PDO::FETCH_OBJ);

    }


    public function getRowByFieldNotDeleted($field, $string)
    {

	$query = $this->db->conn()->prepare(' SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` =  ? AND deleted_at IS NULL ');

	$query->execute(array($string));

	return $query->fetch(PDO::FETCH_OBJ);

    }


    public function create($values)
    {

	return $this->insertRow($this->table, $values);

    }


    public function update($values, $where, $whereValues)
    {

	return $this->updateRow($this->table, $values, $where, $whereValues);

    }




    public function request()
    {

	foreach ($this->fillable as $field) {

		if (isset($this->$field)) {

			$values[$field] = $this->$field;

		} elseif (isset($_POST[$field])) {

			$values[$field] = $_POST[$field];

		}

	}

	return $values;

    }
    
    
    public function validate()
    {
    
	unset( $_SESSION['errors'] );

	foreach ($this->rules as $field => $rules){

		$rules = explode('|', $rules);

		foreach ($rules as $rule) {

			$rule = explode(':', $rule);
			
			$postValue = isset($this->$field) ? $this->$field : $_POST[$field];

			$validate = isset($rule[1]) ? Validation::{$rule[0]}($field, $postValue, $rule[1]) : Validation::{$rule[0]}($field, $postValue);

			if ($validate) {

				Tools::error($validate);

			}

		}

	}

	if (count(Validation::errors())) {

		return false;

	}

	return true;

    }
    
	

    public function insertRow($table, $values)
    {

	if ($this->timestamps) {

		$values['created_at'] = date('Y-m-d H:i:s');
		$values['updated_at'] = date('Y-m-d H:i:s');

	}


	$query = 'INSERT INTO `' . $table . '` (';

	foreach ($values AS $key => $value) {
		$query .= '`' . $key . '`,';
	}

	$query = rtrim($query, ',') . ') VALUES (';

	foreach ($values AS $key => $value) {
		$query .= ' :' . $key . ',';
	}

	$query = rtrim($query, ',') . ' )';

	$query = $this->db->conn()->prepare($query);

	foreach ($values as $key => &$value) {

		if ($value == '') {$value = null;}

		$query->bindParam(':' . $key, $value);

	}

	$query->execute();

	return $this->db->conn()->lastinsertid();

    }


    public function updateRow($table, $values, $where, $whereValues)
    {

	if ($this->timestamps) {

		$values['updated_at'] = date('Y-m-d H:i:s');

	}

	$query = 'UPDATE `' . $table . '` SET ';

	foreach ($values as $key => $value) {

		$execute[$key] = $value;

		$query .= '`' . $key . '` = :' . $key . ', ';

	}

	foreach ($whereValues as $key => $value) {

		$execute[$key] = $value;

	}

	$query = rtrim($query, ', ');

	$query .= ' WHERE ' . $where;

	$query = $this->db->conn()->prepare($query);

	foreach ($execute as $key => &$value) {

		if ($value == '') {$value = null;}

		$query->bindParam(':' . $key, $value);

	}

	$query->execute();

	return true;

    }




}
