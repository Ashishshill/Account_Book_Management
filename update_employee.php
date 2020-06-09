<?php include 'init/header.php';

// checking user has id
if (isset($_GET["id"])) {
    Session::put("employee_id", $_GET["id"]);
}

// session created or not 
if (!Session::exists("employee_id")) {
    Redirect::to('employee.php');
}

$employee = new Employee(); // crateing object
$employee->find($_GET["id"]); //findng employee

// chcking employee exist in database
if (!$employee->exists()) {
    Redirect::to('employee.php');
}

$errors = array();

$data = $employee->data(); // getting data from database


if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'nid' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'phone' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 128,
            ),
            'dob' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'address' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),
            'nationality' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'salary' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'position' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
        ));
        
        if($validation->passed()) {
            try {
                $employee->update(array(
                    'employee_name'  => Input::get('name'),
                    'employee_nid'    => Input::get('nid'),
                    'employee_phone'    => Input::get('phone'),
                    'employee_email'    => Input::get('email'),
                    'employee_dob'    => Input::get('dob'),
                    'employee_address'    => Input::get('address'),
                    'employee_nationality'    => Input::get('nationality'),
                    'employee_salary'    => Input::get('salary'),
                    'employee_position'    => Input::get('position'),
                ), $data->employee_id);
                Session::flash('employee', 'Employee update success!');
                Redirect::to('employee.php');
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
  	 <form method="post">
          <h1 class="h3 mb-2 text-gray-800">Employee</h1>
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
		      <input value="<?= $data->employee_name; ?>" type="text" class="form-control" id="name" placeholder="Enter Full Name" name="name">
		    </div>
		    <div class="form-group">
		      <label for="nid">NID Number:</label>
		      <input value="<?= $data->employee_nid; ?>" type="text" class="form-control" id="nid" placeholder="Enter NID" name="nid">
		    </div>
		    <div class="form-group">
		      <label for="phone">Phon Number:</label>
		      <input value="<?= $data->employee_phone; ?>" type="text" class="form-control" id="phone" placeholder="Enter Phon Number" name="phone">
		    </div>
		    <div class="form-group">
		      <label for="email">Email:</label>
		      <input value="<?= $data->employee_email; ?>" type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
		    </div>
		    <div class="form-group">
		      <label for="dob">Date of Birth</label>
		      <input value="<?= $data->employee_dob; ?>" type="date" class="form-control" id="dob" placeholder="Date of Birth" name="dob">
		    </div>
		    <div class="form-group">
		      <label for="address">Address:</label>
		      <input value="<?= $data->employee_address; ?>" type="text" class="form-control" id="address" placeholder="Enter Address" name="address">
		    </div>
		    <div class="form-group">
		      <label for="nationality">Nationality:</label>
		      <input value="<?= $data->employee_nationality; ?>" type="text" class="form-control" id="nationality" placeholder="Enter Address" name="nationality">
		    </div>
		    <div class="form-group">
		      <label for="salary">Salary:</label>
		      <input value="<?= $data->employee_salary; ?>" type="text" class="form-control" id="salary" placeholder="Enter Salary" name="salary">
		    </div>
		    <div class="form-group">
		      <label for="position">Position:</label>
		      <input value="<?= $data->employee_position; ?>" type="text" class="form-control" id="position" placeholder="Enter Position" name="position">
		    </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     		<button type="submit" class="btn btn-success">Submit</button>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>