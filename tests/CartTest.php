<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class CartTest extends TestCase
{

    protected $cart;
    protected $user;
    protected $db;
    protected $unique_id;

    protected function setUp(): void
    {

	$db = new App\Helpers\Db;
	$user = new App\User($db);
	$db->setDatabase('test_db');  /*  Use test DB to test DB functionality  */
	$this->db = $db;
	$this->cart = new App\Cart( $user, $db);

    }

    public function testShippingIsSet(): void
    {

	$this->cart->setShipping(3.99);
	$this->assertEquals(3.99, $this->cart->getShipping());
    
    }

    public function testSubTotalAddsUp(): void
    {
	
	$cartItems[] = ['quantity' => '2', 'cart_price' => '10'];
	$cartItems[] = ['quantity' => '3', 'cart_price' => '5'];
	$cartItems = json_decode(json_encode($cartItems), false);
	
	$this->cart->setSubTotal($cartItems);
	$subTotal = $this->cart->getSubTotal();
	
	$this->assertEquals(35, $subTotal );

    }


    public function testCountItemsAddsUp(): void
    {
	
	$cartItems[] = ['quantity' => '2', 'cart_price' => '10'];
	$cartItems[] = ['quantity' => '3', 'cart_price' => '5'];
	$cartItems = json_decode(json_encode($cartItems), false);
	
	$this->cart->setCountItems($cartItems);
	$countItems = $this->cart->getCountItems();
	
	$this->assertEquals(5, $countItems );

    }


    public function testItemInsertsIntoDb(): void
    {
    
	/* Clear the cart */
	
	$stmt = $this->db->conn()->prepare(' TRUNCATE TABLE `cart` ');
	$stmt->execute();
    
	$_POST['product_id'] = 5;
	$_POST['cart_price'] = '10.00';
	$_POST['quantity'] = '1';
	
	$this->cart->setUniqueId('uniqueID');
	$request = $this->cart->request();
	
	/* This will insert a cart item in to test cart table */
	
	$inserted_product = $this->cart->add( $request );
	
	/* Inserted cart item should have id of 1 becasue the table was truncated */
	
	$this->assertEquals(1, $inserted_product->id );

    }
    
    
    public function testThereAreItemsInTheCart()
    {
    
	/* Get the cart rows from previous test */

	$this->cart->setUniqueId('uniqueID');
	$this->cart->setCartItems();
	$cartItems = $this->cart->getCartItems();
	
	$cartItems = [ 'cart_price' => $cartItems[0]->cart_price ];
	
	$this->assertEquals(['cart_price' => '10.00'], $cartItems );

    }
    
    
    public function testTotalAddsUp()
    {
    
	/* Get sub total of cart row added in previous test then add shipping */

	$this->cart->setShipping('3.99');
	$this->cart->setUniqueId('uniqueID');
	$this->cart->setCartItems();
	
	$cartItems = $this->cart->getCartItems();
	$this->cart->setSubTotal( $cartItems );
	
	$subTotal = $this->cart->getSubTotal();

	$this->assertEquals('13.99', $this->cart->total() );
	

    }
    
    
    public function testCartUpdatesWithNewQuantityWithWrongUniqueId()
    {
	
	$newQuantity = 3;
	
	/* Set the wrong unique id */
	
	$this->cart->setUniqueId('WrongUniqueID');
	
	$updatedCartRow = $this->cart->updateCart( 1, $newQuantity );
	
	/* This shouldn't update the cart becasue the unique id is wrong */
	
	$this->assertNotEquals(3, $updatedCartRow->quantity);
	

    }
    
    
    public function testCartUpdatesWithNewQuantityWithCorrectUniqueId()
    {
	
	$newQuantity = 3;
	
	/* Correct unique id */
	
	$this->cart->setUniqueId('uniqueID');
	
	$updatedCartRow = $this->cart->updateCart( 1, $newQuantity );
	
	/* This should update the cart becasue the unique id is correct */
	
	$this->assertEquals(3, $updatedCartRow->quantity);

    }


    
    public function testCartDeletesRowWithWrongUniqueId()
    {
	
	/* Set the wrong unique id */
	
	$this->cart->setUniqueId('WrongUniqueID');
	
	$deletedCartRow = $this->cart->delete(1);
	
	/* This shouldn't delete the row becasue the unique id is wrong */
	
	/* deleted_at should still be NULL because deleting the row sets a datetime in the deleted_at field */
	
	$this->assertEquals(NULL, $deletedCartRow->deleted_at);

    }
    
    
    public function testCartDeletesRowWithCorrectUniqueId()
    {
	
	/* Set the wrong unique id */
	
	$this->cart->setUniqueId('uniqueID');
	
	$deletedCartRow = $this->cart->delete(1);
	
	/* This should delete the row becasue the unique id is correct */
	
	/* deleted_at should not be NULL now because deleting the row sets a datetime in the deleted_at field */
	
	$this->assertNotEquals(NULL, $deletedCartRow->deleted_at);

    }







}
