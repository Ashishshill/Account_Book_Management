<?php include 'init/header.php';


// checking user has id
if (isset($_GET["id"])) {
    Session::put("customer_id", $_GET["id"]);
}

// session created or not 
if (!Session::exists("customer_id")) {
    Redirect::to('customer.php');
}

$customer = new Customer(); // crateing object
$customer->find($_GET["id"]); //findng employee

// chcking employee exist in database
if (!$customer->exists()) {
    Redirect::to('customer.php');
}

$errors = array();

$data = $customer->data(); // getting data from database


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
            try {
                $customer_image = $customer->uploadFile($_FILES['image']);
                $customer->update(array(
                    'customer_img'       => $customer_image,
                    'customer_name'  => Input::get('name'),
                    'customer_number'    => Input::get('number'),
                    'customer_email'    => Input::get('email'),
                    'customer_wedsite'    => Input::get('website'),
                    'customer_address'    => Input::get('address'),
                    'customer_shop_address'    => Input::get('shop'),
                ), $data->customer_id);
                Session::flash('customer', 'Customer update success!');
                Redirect::to('customer.php');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            $errors = $validation->errors();
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
                  <input type="text" value="<?= $data->customer_name; ?>"  class="form-control" id="name" placeholder="Enter Full Name" name="name">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Chose Your Photo</label>
                <input type="file" name="image" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
            </div>
            <div class="form-row">
                <div class="col-3 form-group">
                  <label for="number">Customer Phone Number:</label>
                  <input type="text" value="<?= $data->customer_number; ?>" class="form-control" id="nid" placeholder="Enter Customer Phone Number" name="number">
                </div>
                <div class="col-3 form-group">
                  <label for="email">Customer Email:</label>
                  <input type="email" value="<?= $data->customer_email; ?>" class="form-control" id="email" placeholder="Enter Email" name="email">
                </div>
            </div>
            <div class="form-row"> 
                <div class="col-6 form-group">
                  <label for="website">Customer Website:</label>
                  <input type="text" value="<?= $data->customer_wedsite; ?>" class="form-control" id="website" placeholder="Customer Website" name="website">
                </div>
            </div>
            <div class="form-row">
                <div class="col-6 form-group">
                  <label for="address">Customer Full Address:</label>
                  <textarea type="text" class="form-control" id="address" placeholder="Enter Address" name="address"><?= $data->customer_address; ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6 form-group">
                  <label for="shop">Customer Shop Address:</label>
                  <input type="text" value="<?= $data->customer_shop_address; ?>" class="form-control" id="shop" placeholder="Enter Shop address" name="shop">
                </div>
            </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     		<button type="submit" class="btn btn-success">Update Customer</button>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>