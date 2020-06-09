<?php require_once "init/login_header.php"; 
$errors = array();
if(Input::exists()) {
  if(Token::check(Input::get('token'))) {

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array('required' => true),
      'password' => array('required' => true)
    ));


    if($validation->passed()) {
      // Login user
      $user = new User();

      $remember = (Input::get('remember') === 'on') ? true : false;
      $login = $user->login(Input::get('username'), Input::get('password'), $remember);

      if($login) {
        // echo 'Success';
        Redirect::to('index.php');
      } else {
        echo '<p>Sorry, logging in failed';
      }

    } else {
      $errors = $validation->errors();


      // if (!empty($errors)) {
      // foreach($errors as $error) {
      //   echo $error, '<br>';
      // }
      // }


    }

  }
}

?>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Admin Login!</h1>
                  </div>
                  <form method="post" class="user">

                     <?php  if (!empty($errors)) {
                      foreach($errors as $error) {
                        echo $error, '<br>';
                      }
                      }?> 
                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                    <input type="submit" name="" value="login" class="btn btn-primary btn-user btn-block">
                  </form>
                  <hr><!-- 
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
                  </div> -->
                </div>
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
