<?php

namespace App;

use App\Helpers\Db;

class OrderItem extends ObjectModel
{

    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'title'];
    protected $db;
    

    public function __construct(Db $db)
    {
	$this->db = $db;
    }


    public function setOrderItems(int $order_id)
    {
	$this->order_items = $this->execute("SELECT * FROM order_items WHERE order_id = ?  ", [$order_id] );
    }
    
    
    public function getOrderItems(): array
    {

	return $this->order_items;

    }
		
		
    public function add(array $request): ?object
    {

	$insert_id = $this->create( $request );
	
		if( ! is_numeric($insert_id) ){

			return null;
		
		}
		
	return $this->find($insert_id);

    }


}
