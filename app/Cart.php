<?php

namespace App;

use App\Helpers\Db;
use PDO;

class Cart extends ObjectModel
{

    protected $table = 'cart';
    protected $fillable = ['product_id', 'quantity', 'cart_price', 'unique_id'];
    protected $unique_id;
    protected $user;
    protected $db;
    protected $sub_total;
    protected $shipping = 5.99;
    protected $cart_items;
    protected $count_cart_items;

    public function __construct(User $user, Db $db)
    {

	$this->user = $user;
	$this->db = $db;
	$this->unique_id = $this->user->getUniqueId();

    }
    

    public function setUniqueId($unique_id)
    {

	$this->unique_id = $unique_id;

    }



    public function setCartItems()
    {

	$this->cart_items =  $this->execute("SELECT *, cart.id AS cart_id FROM cart
					LEFT JOIN products ON products.id = cart.product_id
					WHERE cart.unique_id = ? AND cart.quantity > '0' AND cart.deleted_at IS NULL ", [$this->unique_id] );

    }
    
    
    public function getCartItems(): array
    {

	return $this->cart_items;

    }
    

    public function setSubTotal(array $cartItems)
    {

	$subTotal = 0;

	foreach($cartItems as $row){

		$subTotal += ( $row->quantity * $row->cart_price );

	}

	$this->sub_total = $subTotal;

    }
    


    public function getSubTotal(): float
    {

	return $this->sub_total;

    }

    
    
    public function setShipping($amount)
    {
	
	$this->shipping = $amount;

    }


    public function getShipping(): float
    {

	return $this->shipping;

    }


    public function total(): float
    {

	return $this->sub_total + $this->shipping;

    }
    
    
    public function setCountItems(array $cartItems )
    {	
	
	$countItems = 0;

	foreach($cartItems as $row){

		$countItems += $row->quantity;

	}
	
	$this->count_cart_items = $countItems;

    }
    
    
    public function getCountItems(): int
    {

	return $this->count_cart_items;

    }



    public function add(array $request): ?object
    {

	$insert_id = $this->create( $request );
	
		if( ! is_numeric($insert_id) ){

			return null;
		
		}
		
		return $this->find($insert_id);

    }



    public function delete(int $cart_id): object
    {

	$this->updateRow($this->table, ['deleted_at' => date('Y-m-d H:i:s')], 'id = :id AND unique_id = :unique_id  ', [ 'id' => $cart_id, 'unique_id' => $this->unique_id ] );
	
	return $this->find($cart_id);

    }


    public function updateCart(int $cart_id, int $quantity ): object
    {

	$this->updateRow($this->table, ['quantity' => $quantity], 'id = :id AND unique_id = :unique_id  ', [ 'id' => $cart_id, 'unique_id' => $this->unique_id ] );
	
	return $this->find($cart_id);

    }








}
