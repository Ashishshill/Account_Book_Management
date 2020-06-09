<?php include 'init/header.php';


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
                'max' => 128,
            ),
            'quantity' => array(
                'required' => true,
            ),
            'catagory' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),
        ));
        
        if($validation->passed()) {
            $product = new Product();

            try {
                $product->create(array(
                    'product_name'  => Input::get('name'),
                    'product_details'    => Input::get('details'),
                    'product_price'    => Input::get('price'),
                    'product_qnt'    => Input::get('quantity'),
                    'product_category'    => Input::get('catagory'),
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
  	 <form method="post" data-toggle="validator" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col-6 form-group">
                  <label for="name">Product Name:</label>
                  <input type="text" pattern="^[_A-z ]{1,}$" maxlength="40" class="form-control" id="name" placeholder="Enter Product Name" name="name" required="">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-3 form-group">
                  <label for="text">Product Details / Model:</label>
                  <input type="text"  class="form-control" id="text" placeholder="Product Details" name="details">
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
                  <label for="website">Product Quantity:</label>
                  <input type="number" class="form-control" id="price" placeholder="Product Quantity" name="quantity" min="1">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-6 form-group">
                  <label for="website">Product Catagory:</label>
                  <input type="text" class="form-control" id="website" pattern="^[_A-z ]{1,}$" placeholder="Product Catagory" name="catagory">
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
    var contactPattern = new RegExp("^(\\+8801)?(\\d+)$");

    function chkInput() {
        var v = $("#contact").val().charAt($("#contact").val().length - 1);
        return contactPattern.test(v);
    }

    $("#contact").on('keyup keypress blur change input keydown mousedown mouseup select contextmenu drop', function () {
        if ($(this).val().length == 1 || ($(this).val().length == 2 && $("#contact").val().charAt($("#contact").val().length - 1) == "0")) $(this).val('+8801');
        else {
            var res = chkInput();
            if (!res) $(this).val($(this).val().slice(0, -1));
        }
    });
</script>