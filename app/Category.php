<?php

namespace App;

use App\Helpers\Db;


class Category extends ObjectModel
{

    protected $table = 'categories';
    protected $fillable = ['title', 'seo_url', 'sort_order'];
    protected $rules = [];
    protected $db;
    protected $categories;
    
    public function __construct(Db $db)
    {

	$this->db = $db;

    }


    public function setTable($table)
    {

	$this->table = $table;

    }


    public function setCategories()
    {

	$this->catgories = $this->execute('SELECT * FROM '.$this->table.' WHERE deleted_at IS NULL ORDER BY sort_order ASC ', [] );

    }


    public function getCategories(): array
    {
    
	return $this->catgories;
	
    }
    

    public function add(array $request): ?object
    {
	
	$insert_id = $this->create( $request );
	
		if( ! is_numeric($insert_id) ){

			return null;
		
		}
		
	return $this->find($insert_id);

    }
    
    
    public function updateCategory(int $category_id, array $request): object
    {

	$this->update($request, 'id = :id', ['id' => $category_id]);

	return $this->find($category_id);

    }


    public function delete($category_id): object
    {

	$this->updateRow($this->table, ['deleted_at' => date('Y-m-d H:i:s')], 'id = :id  ', [ 'id' => $category_id ] );
	
	return $this->find($category_id);

    }






}
