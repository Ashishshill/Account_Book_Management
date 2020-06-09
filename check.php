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
$customer->find($_GET["id"]); //findng customer

// chcking customer exist in database
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
            $customer = new Customer();

            try {
                $customer->create(array(
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
  	 <form method="post">
          <h1 class="h3 mb-2 text-gray-800">Customer</h1>
          <?php if (!empty($errors)): ?>
            <?php foreach ($validation->errors() as $error): ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <?= $error; ?>
                </div>
            <?php endforeach ?>
          <?php endif ?>        
	  	 	<div class="form-group">
			    <label for="exampleInputFile">Chose Your Photo</label>
			    <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
			    <h3> </h3>
		  </div>
		    <div class="form-group">
		      <label for="name">Full Name:</label>
		      <input value="<?= $data->customer_name; ?>" type="text" class="form-control" id="name" placeholder="Enter Full Name" name="name">
		    </div>
		    <div class="form-group">
		      <label for="nid">Customer Number:</label>
		      <input value="<?= $data->customer_number; ?>" type="text" class="form-control" id="nid" placeholder="Enter NID" name="nid">
		    </div>
		    <div class="form-group">
		      <label for="phone">Customer Email:</label>
		      <input value="<?= $data->customer_email; ?>" type="text" class="form-control" id="phone" placeholder="Enter Phon Number" name="phone">
		    </div>
		    <div class="form-group">
		      <label for="email">Customer Website:</label>
		      <input value="<?= $data->customer_wedsite; ?>" type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
		    </div>
		    <div class="form-group">
		      <label for="address">Address:</label>
		      <input value="<?= $data->customer_address; ?>" type="text" class="form-control" id="address" placeholder="Enter Address" name="address">
		    </div>
		    <div class="form-group">
		      <label for="nationality">Nationality:</label>
		      <input value="<?= $data->customer_shop_address; ?>" type="text" class="form-control" id="nationality" placeholder="Enter Address" name="nationality">
		    </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     		<button type="submit" class="btn btn-success">Submit</button>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>