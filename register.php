<?php 
require_once 'init/login_header.php'; 

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,    
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));
        
        if($validation->passed()) {
            $user = new User();

            $salt = Hash::salt(32);

            try {
                $user->create(array(
                    'username'  => Input::get('username'),
                    'password'  => Hash::make(Input::get('password'), $salt),
                    'salt'    => $salt,
                    'name'    => Input::get('name'),
                    'joined'  => date('Y-m-d H:i:s'),
                    'group'   => 1,
                ));
                Session::flash('login.php', 'You have been registered and can now log in!');
                // header('Location: index.php');
                Redirect::to('login.php');
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

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>
            <form action="" method="post" class="user">
                <div class="form-group">
                    <input type="text" name="username" class="form-control form-control-user" id="exampleFirstName" value="<?php echo escape(Input::get('username')); ?>" placeholder="Company Name / User Name">
            </div>
            <div class="form-group">
              <input type="text" name="name" class="form-control form-control-user" id="name" value="<?php echo escape(Input::get('name')); ?>" placeholder="Your Name">
          </div>
          <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
            </div>
            <div class="col-sm-6">
                <input type="password" name="password_again" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
            </div>
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
        <input type="submit" value="Register" class="btn btn-primary btn-user btn-block" >

    </input>
    <hr>
</form>
<hr>
<div class="text-center">
  <a class="small" href="forgot-password.php">Forgot Password?</a>
</div>
<div class="text-center">
  <a class="small" href="login.php">Already have an account? Login!</a>
</div>
</div>
</div>
</div>
</div>
</div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
