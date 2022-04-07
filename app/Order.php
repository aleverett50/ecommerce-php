<?php

namespace App;

use App\Helpers\Db;

class Order extends ObjectModel
{

    protected $table = 'orders';
    protected $fillable = ['user_id', 'shipping', 'total_cost'];
    protected $db;
    protected $user;
    protected $orders;

    public function __construct(Db $db, User $user )
    {

	$this->user = $user;
	$this->db = $db;

    }

	
    public function setOrders(string $status)
    {

	$this->orders = $this->execute("SELECT *, orders.created_at AS order_date, orders.id AS order_id 
							FROM orders LEFT JOIN users ON users.id = orders.user_id 
							WHERE orders.deleted_at IS NULL AND orders.status = ? ORDER BY orders.id DESC ", [$status]);

    }
    
   
    public function setSearchedOrders(string $search)
    {

	$this->orders = $this->execute("SELECT *, orders.created_at AS order_date, orders.id AS order_id 
							FROM orders LEFT JOIN users ON users.id = orders.user_id 
							WHERE ( orders.order_number LIKE ? OR users.last_name LIKE ? ) 
							AND orders.deleted_at IS NULL ORDER BY orders.id DESC ", ['%'.$search.'%', '%'.$search.'%']);

    }   
    
    
    public function setCustomerOrders(int $user_id)
    {

	$this->orders = $this->execute("SELECT *, orders.created_at AS order_date, orders.id AS order_id 
							FROM orders WHERE orders.user_id = ? AND orders.deleted_at IS NULL AND 
							orders.status != 'Pending' ORDER BY orders.id DESC ", [$user_id]);

    }
    
    
    public function getOrders(): array
    {

	return $this->orders;

    }


		
    public function setOrderToPaid(int $order_id): object
    {

	$this->updateRow($this->table, ['status' => 'New'], 'id = :id LIMIT 1 ', [ 'id' => $order_id ] );
	
	return $this->find($order_id);

    }



    public function add(array $request): ?object
    {

	$insert_id = $this->create( $request );
	
		if( ! is_numeric($insert_id) ){

			return null;
		
		}
		
	return $this->find($insert_id);

    }
		
		
    public function updateStatus(int $order_id, string $status): object
    {

	$this->updateRow($this->table, [ 'status' => $_POST['status'] ], 'id = :id LIMIT 1 ', [ 'id' => $order_id ] );
	
	return $this->find($order_id);

    }




    



}
