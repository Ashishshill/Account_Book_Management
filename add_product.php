<?php include 'init/header.php' ;

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'details' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'price' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'quantity' => array(
                'required' => true,
            ),
            'catagory' => array(
                'required' => true,
            ),
        ));
        
        if($validation->passed()) {
            $product = new Product();

            try {
                    $product->create(array(
                    'product_name'      => Input::get('name'),
                    'product_details'   => Input::get('details'),
                    'product_price'     => Input::get('price'),
                    'product_qnt'       => Input::get('quantity'),
                    'Category'          => Input::get('catagory'),
                ));
                Session::flash('product', 'Product added success!');
                Redirect::to('product.php');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
 ?>

<div class="daa_employ">
 <div class="container"> 
  	 <form method="post" data-toggle="validator" enctype="multipart/form-data" >
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="name">Product Name:</label>
              <input type="text" pattern="^[_A-z ]{1,}$" class="form-control" id="name" placeholder="Product Name" name="name" required="">
              <div class="help-block with-errors text-center"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="details">Product Details:</label>
              <input type="text" class="form-control" id="details" placeholder="Product Details" name="details">
              <div class="help-block with-errors text-center"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="price">Product Price:</label>
              <input type="text" class="form-control" id="price" placeholder="Product Price" name="price">
              <div class="help-block with-errors text-center"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="quantity">Product Quantity:</label>
              <input type="number" class="form-control" id="quantity" min="1" placeholder="Product Quantity" name="quantity">
              <div class="help-block with-errors text-center"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="catagory">Product Catagory:</label>
              <input type="text" class="form-control" pattern="^[_A-z ]{1,}$" id="catagory" placeholder="Product Catagory" name="catagory">
              <div class="help-block with-errors text-center"></div>
            </div>
        </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     <button type="submit" class="btn btn-success">Add Product</button>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>


<script type="text/javascript">
    $("#price").inputFilter(function (value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200000);
    });
</script>