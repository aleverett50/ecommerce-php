<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{

    protected $product;
    protected $db;

    protected function setUp(): void
    {
	
	$db = new App\Helpers\Db;
	$db->setDatabase('test_db');  /*  Use test DB to test DB inserts  */
	$this->db = $db;
	$this->product = new App\Product($db);

    }


    public function testProductInsertsIntoDb(): void
    {
	
	$stmt = $this->db->conn()->prepare(' TRUNCATE TABLE `products` ');
	$stmt->execute();
    
	$_POST['title'] = 'Handbag';
	$_POST['seo_url'] = 'handbag-1';
	$_POST['category_id'] = '["1"]';
	
	$request = $this->product->request();
	
	/* This will insert a product item in to products table */
	
	$inserted_product = $this->product->add( $request );
	
	/* Inserted product should have id of 1 becasue the table was truncated */
	
	$this->assertEquals(1, $inserted_product->id );

    }
    
    
    public function testProductsAreThere()
    {
    
	/* Get the product row from previous test */

	$this->product->setProducts('byCategory', 1);
	$products = $this->product->getProducts();
	
	$products = [ 'title' => $products[0]->title ];
	
	$this->assertEquals(['title' => 'Handbag'], $products );

    }
    
    
    public function testProductUpdates()
    {
	
	$_POST['title'] = 'T-Shirt';
	$_POST['seo_url'] = 't-shirt';
	$_POST['category_id'] = '["2"]';
	
	$request = $this->product->request();
	
	$updatedRow = $this->product->updateProduct(1, $request);
	
	/* This should update the previously inserted row */
	
	$this->assertEquals('T-Shirt', $updatedRow->title);

    }


    
    
    public function testProductDeleted()
    {
	
	$deletedRow = $this->product->delete(1);
	
	/* deleted_at should not be NULL now because deleting the row sets a datetime in the deleted_at field */
	
	$this->assertNotEquals(NULL, $deletedRow->deleted_at);

    }


    public function testFileValidationWithAllowedFileType()
    {
    
	$allowedFiles = ['image/jpeg', 'image/png'];
	
	$files['file-1']['size'] = 1000;
	$files['file-1']['type'] = 'image/jpeg';
	
	$fileValidation = $this->product->checkValidFiles( $files, $allowedFiles );
	
	/* $fileValidation should return true since image/jpeg is an allowed filetype */
	
	$this->assertEquals($fileValidation , true);

    }
    
    
        public function testFileValidationWithNotAllowedFileType()
    {
    
	$allowedFiles = ['image/jpeg', 'image/png'];
	
	$files['file-1']['size'] = 1000;
	$files['file-1']['type'] = 'text/plain';
	
	$fileValidation = $this->product->checkValidFiles( $files, $allowedFiles );
	
	/* $fileValidation should return false since image/jpeg is an allowed filetype */
	
	$this->assertEquals($fileValidation , false);

    }






}
