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
            $employee = new Employee();

            try {
                $employee_img = $employee->uploadFile($_FILES['employee_img']);
                $employee->create(array(
                    'employee_img'    => $employee_img,
                    'employee_name'  => Input::get('name'),
                    'employee_nid'    => Input::get('nid'),
                    'employee_phone'    => Input::get('phone'),
                    'employee_email'    => Input::get('email'),
                    'employee_dob'    => Input::get('dob'),
                    'employee_address'    => Input::get('address'),
                    'employee_nationality'    => Input::get('nationality'),
                    'employee_salary'    => Input::get('salary'),
                    'employee_position'    => Input::get('position'),
                ));
                Session::flash('employee', 'Employee added success!');
                Redirect::to('employee.php');
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
  	 <form method="post" enctype="multipart/form-data" data-toggle="validator" id="form">
	  	 	<div class="form-group" >
			    <label for="employee_img">Chose Your Photo</label>
			    <input type="file" class="form-control-file" id="employee_img" name="employee_img" aria-describedby="fileHelp">
			    <h3> </h3>
		  </div>
		    <div class="form-row">
                <div class="col form-group">
    		      <label for="name">Enter Full Name:</label>
    		      <input type="text" pattern="^[_A-z ]{1,}$" class="form-control" id="name" placeholder="Enter Full Name" name="name">
                  <div class="help-block with-errors text-center"></div>
                </div>
                <div class="col form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                  <div class="help-block with-errors text-center"></div>
                </div>
		    </div>
            <div class="form-row">
    		    <div class="col-6 form-group">
    		      <label for="nid">NID Number:</label>
    		      <input type="text" class="form-control" id="nid" placeholder="Enter NID" name="nid">
                  <div class="help-block with-errors text-center"></div>
    		    </div>
                <div class="col-3 form-group">
                  <label for="phone">Phone Number:</label>
                  <input type="textbox" class="form-control" id="contact" placeholder="Enter Phone Number" name="phone">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
		    <div class="col-3 form-group">
		      <label for="dob">Date of Birth</label>
		      <input type="text" class="form-control" id="date" placeholder="Date of Birth" name="dob">
              <div class="help-block with-errors text-center"></div>
		    </div>
		    <div class="col-6 form-group">
		      <label for="address">Address:</label>
		      <textarea type="text" class="form-control" id="address" placeholder="Enter Address" name="address" cols="30" rows="10"> </textarea>
              <div class="help-block with-errors text-center"></div>
             
		    </div>
            <div class="form-row">
    		    <div class="col-3 form-group">
    		      <label for="nationality">Nationality:</label>
    		      <input type="text" class="form-control" pattern="^[_A-z ]{1,}$" id="nationality" placeholder="Enter Address" name="nationality">
                  <div class="help-block with-errors text-center"></div>
    		    </div>
                <div class="col-3 form-group">
                  <label for="position">Position:</label>
                  <input type="text" class="form-control" pattern="^[_A-z ]{1,}$" id="position" placeholder="Enter Position" name="position">
                  <div class="help-block with-errors text-center"></div>
                </div>
            </div>
		    <div class="col-3 form-group">
		      <label for="salary">Salary:</label>
		      <input type="text" class="form-control" id="salary" placeholder="Enter Salary" name="salary">
              <div class="help-block with-errors text-center"></div>
		    </div>
		    <input type="hidden" name="token" value="<?php echo Token::generate();
                ?>" />
            <div class="form-row">

                <div>
                    <p class="text-danger font-bold" id="extra_msg"></p>
                </div>

                <div class="col-3 form-group">
         		 <button type="submit" class="btn btn-success" style="padding: 14px 40px;">Submit</button>
                </div>
            </div>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>


<script type="text/javascript">
    $("#nid").inputFilter(function (value) {
        return /^\d*$/.test(value);
    });

    $("#salary").inputFilter(function (value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 30000);
    });

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

    var form = $("#form");

    form.submit(function(event){
        event.preventDefault();
        var birth = $("#date");
        console.log(birth.val());
        var birthDate = new Date($('#date').val());
        var today = new Date();
        var age = Math.floor((today-birthDate) / (365.25 * 24 * 60 * 60 * 1000));
        // $('#age').html(age+' years old');
        // console.log("You are " + age + " years old!!!");
        if (age >= 18) {
            form.unbind().submit();
        }
        else {
            $("#extra_msg").html("You are not old enough to carry out the process! You have to minimum 18 years old.");
        }
    });
</script>