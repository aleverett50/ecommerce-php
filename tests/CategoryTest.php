<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class CategoryTest extends TestCase
{

    protected $category;
    protected $db;

    protected function setUp(): void
    {
	
	$db = new App\Helpers\Db;
	$db->setDatabase('test_db');  /*  Use test DB to test DB inserts  */
	$this->db = $db;
	$this->category = new App\Category($db);

    }


    public function testCategoryInsertsIntoDb(): void
    {
	
	$stmt = $this->db->conn()->prepare(' TRUNCATE TABLE `categories` ');
	$stmt->execute();
    
	$_POST['title'] = 'Trousers';
	$_POST['seo_url'] = 'trousers';
	$_POST['sort_order'] = '10';
	
	$request = $this->category->request();
	
	/* This will insert a category item in to test category table */
	
	$inserted_category = $this->category->add( $request );
	
	/* Inserted category should have id of 1 becasue the table was truncated */
	
	$this->assertEquals(1, $inserted_category->id );

    }
    
    
    public function testCategoriesAreThere()
    {
    
	/* Get the category row from previous test */

	$this->category->setCategories();
	$categories = $this->category->getCategories();
	
	$categories = [ 'title' => $categories[0]->title ];
	
	$this->assertEquals(['title' => 'Trousers'], $categories );

    }
    
    
    public function testCategoryUpdates()
    {
	
	$_POST['title'] = 'Baggy Trousers';
	$_POST['seo_url'] = 'trousers';
	$_POST['sort_order'] = '10';
	
	$request = $this->category->request();
	
	$updatedRow = $this->category->updateCategory(1, $request);
	
	/* This should update the previously inserted category */
	
	$this->assertEquals('Baggy Trousers', $updatedRow->title);

    }


    
    
    public function testCategoryDeleted()
    {
	
	$deletedRow = $this->category->delete(1);
	
	/* deleted_at should not be NULL now because deleting the row sets a datetime in the deleted_at field */
	
	$this->assertNotEquals(NULL, $deletedRow->deleted_at);

    }







}
