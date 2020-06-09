<?php include 'init/header.php';

// checking user has id
if (isset($_GET["id"])) {
    Session::put("product_id", $_GET["id"]);
}

// session created or not 
if (!Session::exists("product_id")) {
    Redirect::to('product.php');
}

$product = new Product(); // crateing object
$product->find($_GET["id"]); //findng employee

// chcking employee exist in database
if (!$product->exists()) {
    Redirect::to('product.php');
}

$errors = array();

$data = $product->data(); // getting data from database


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
            try {
                $product->update(array(
                    'product_name'    => Input::get('name'),
                    'product_details' => Input::get('details'),
                    'product_price'   => Input::get('price'),
                    'product_qnt'     => Input::get('quantity'),
                    'product_category' => Input::get('catagory'),
                ), $data->product_id);
                Session::flash('product', 'Product update success!');
                Redirect::to('product.php');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            $errors = $validation->errors();
        }
    }
}


?>


<div class="daa_product">
 <div class="container"> 
  	 <form method="post">
          <h1 class="h3 mb-2 text-gray-800">Edit Product</h1>
          <?php if (!empty($errors)): ?>
            <?php foreach ($validation->errors() as $error): ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <?= $error; ?>
                </div>
            <?php endforeach ?>
          <?php endif ?>        
	  	 	<!-- <div class="form-group">
			    <label for="exampleInputFile">Chose Your Photo</label>
			    <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
			    <h3> </h3>
		  </div> -->
            <div class="form-row">
            <div class="col-6 form-group">
              <label for="name">Product Name:</label>
              <input type="text" value="<?= $data->product_name; ?>" class="form-control" id="name" placeholder="Product Name" name="name" required="">
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="details">Product Details:</label>
              <textarea type="text" value="<?= $data->product_details; ?>" class="form-control" id="details" placeholder="Product Details" name="details"><?= $data->product_details; ?></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="price">Product Price:</label>
              <input type="number" value="<?= $data->product_price; ?>" class="form-control" id="price" placeholder="Product Price" name="price">
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="quantity">Product Quantity:</label>
              <input type="number" value="<?= $data->product_qnt; ?>" class="form-control" id="quantity" placeholder="Product Quantity" name="quantity">
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="catagory">Product Catagory:</label>
              <input type="text" value="<?= $data->product_category; ?>" class="form-control" id="catagory" placeholder="Product Catagory" name="catagory">
            </div>
        </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     		<button type="submit" class="btn btn-success">Submit</button>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>