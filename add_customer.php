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
            'number' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 128,
            ),
            'website' => array(
                'min' => 2,
                'max' => 64,
            ),
            'address' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),
            'shop' => array(
                'min' => 2,
                'max' => 64,
            ),
        ));
        
        if($validation->passed()) {
            $customer = new Customer();

            try {
                $customer_image = $customer->uploadFile($_FILES['image']);
                $customer->create(array(
                    'customer_img'       => $customer_image,
                    'customer_name'  => Input::get('name'),
                    'customer_number'    => Input::get('number'),
                    'customer_email'    => Input::get('email'),
                    'customer_wedsite'    => Input::get('website'),
                    'customer_address'    => Input::get('address'),
                    'customer_shop_address'    => Input::get('shop'),
                ));
                Session::flash('customer', 'Customer added success!');
                Redirect::to('customer.php');
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
                  <label for="name">Customer Full Name:</label>
                  <input type="text" pattern="^[_A-z ]{1,}$" maxlength="40" class="form-control" id="name" placeholder="Enter Full Name" name="name" required="">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Chose Your Photo</label>
                <input type="file" name="image" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                <div class="help-block with-errors text-center"></div>
            </div>
            <div class="form-row">
                <div class="col-3 form-group">
                  <label for="number">Customer Phone Number:</label>
                  <input type="text" maxlength="14" class="form-control" id="contact" placeholder="Enter Customer Phone Number" name="number">
                  <div class="help-block with-errors text-center"></div>
                </div>
                <div class="col-3 form-group">
                  <label for="email">Customer Email:</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-6 form-group">
                  <label for="website">Customer Website:</label>
                  <input type="url" class="form-control" id="website" placeholder="Customer Website" name="website">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6 form-group">
                  <label for="address">Customer Full Address:</label>
                  <textarea type="text" class="form-control" id="address" placeholder="Enter Address" name="address"></textarea>
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6 form-group">
                  <label for="shop">Customer Shop Address:</label>
                  <input type="text" class="form-control" id="shop" placeholder="Enter Shop address" name="shop">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     		<button type="submit" class="btn btn-success">Add Customer</button>
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