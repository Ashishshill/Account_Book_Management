<?php include 'init/header.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array(
                'required' => true,
            )
        ));
        if($validation->passed()) {
            Redirect::to('send_invoice.php?id=' . $_GET["id"] . '&email=' . Input::get('email'));
        } else {
            $errors = $validation->errors();
        }
    }
}

?>

<form method="post" enctype="multipart/form-data">
    <div class="animated fadeIn">
        <!--/.col-->
        <div class="card">
            <div class="card-header"><strong>Send Mail</strong></div>
            <div class="card-body card-block">
            <div class="col-6">
                <div class="form-group">
                	<label for="company" class=" form-control-label">Email Address</label>
                	<input type="text" id="company" name="email" placeholder="Enter Email Address" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                	<label for="country" class=" form-control-label">Note</label>
                	<input type="text" id="country" name="note" placeholder="Note" class="form-control">
                </div>
            </div>
            <div class="col-6">
                 <div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
                    <input type="submit" value="Send" name="Send" class="btn btn-primary btn-block">
                </div>
            </div>
            </div>
        </div>
    </div>
</form>
<?php include 'init/footer.php' ?>