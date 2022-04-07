<?php	

namespace App;

use App\Helpers\Db;


class Product extends ObjectModel{

	protected $table = 'products';
	protected $fillable = ['title', 'seo_url', 'category_id', 'price', 'special_offer_price', 'description', 'images'];
	protected $rules = [];
	protected $db;
	protected $products;
			
			
    public function __construct( Db $db )
    {
    
	$this->db = $db;
    
    }
    
    
    public function setProducts(...$arguments)
    {
	
		if( $arguments[0] == 'byCategory' ){
		
			$this->products = $this->execute("SELECT * FROM products WHERE category_id LIKE ? AND 
									products.deleted_at IS NULL ORDER BY products.id DESC  ", ["%\"".$arguments[1]."\"%"] );
		
		}else{

		$this->products = $this->execute('SELECT * FROM products WHERE products.deleted_at IS NULL 
								ORDER BY products.category_id ASC  ', [] );
								
		}

    }


    public function getProducts(): array
    {

	return $this->products;

    }
    


    public function add(array $request): ?object
    {
	
	$insert_id = $this->create( $request );
	
		if( ! is_numeric($insert_id) ){

			return null;
		
		}
		
	return $this->find($insert_id);

    }
		
		
    public function updateProduct(int $product_id, array $request): object
    {

	$this->update($request, 'id = :id', ['id' => $product_id]);

	return $this->find($product_id);

    }


    public function delete(int $product_id): object
    {

	$this->updateRow($this->table, ['deleted_at' => date('Y-m-d H:i:s')], 'id = :id  ', [ 'id' => $product_id ] );
	
	return $this->find($product_id);

    }
    
    
    public function checkValidFiles( array $files, array $allowedFiles ): bool
    {

	foreach($files as $key => $file){

		if( $files[$key]['size'] > 0 ){	
		
			/* Check filetypes first before any updates */
		
			if( ! in_array( $files[$key]['type'], $allowedFiles ) ){
			
				return false;
			
			}
		
		}

	}
	
	return true;

    }





}
