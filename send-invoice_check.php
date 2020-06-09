<?php
include 'init/header.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'email' => array(
                'required' => true,
            ),
            'note' => array(
                'min' => 2,
                'max' => 500,
            ),
        ));
        
        if($validation->passed()) {
            try {
                $mail = new PHPMailer;

				//$mail->SMTPDebug = 3;                               // Enable verbose debug output

				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'aalzaman19@gmail.com';                 // SMTP username
				$mail->Password = 'iwillcoziknowican';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to

				$mail->setFrom('aalzaman19@gmail.com', 'Mailer');
				$mail->addReplyTo('aalzaman19@gmail.com', 'Information');

				
				$mail->addAddress(Input::get('email'), 'Joe User');     // Add a recipient

				$mail->Subject = 'Here is the subject';
				$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
				    echo 'Message could not be sent.';
				    echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
				    echo 'Message has been sent';
				}
                Session::flash('invoice', 'You have been registered and can now log in!');
                // header('Location: index.php');
                Redirect::to('invoice.php');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            $errors = $validation->errors();
        }
    }
}

?>
<!-- Header-->

<form method="post" enctype="multipart/form-data">
    <div class="animated fadeIn">
        <!--/.col-->
        <div class="card">
            <div class="card-header"><strong>Send Mail</strong></div>
            <div class="card-body card-block">
                <div class="form-group">
                	<label for="company" class=" form-control-label">Email Address</label>
                	<input type="text" id="company" name="email" placeholder="Enter Email Address" class="form-control">
                </div>
                <div class="form-group">
                	<label for="country" class=" form-control-label">Note</label>
                	<input type="text" id="country" name="note" placeholder="Note" class="form-control">
                </div>
                <div>
                	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
					<input type="submit" value="Send" name="Send" class="btn btn-primary btn-block">
                </div>
            </div>
        </div>
    </div>
</form>
        
        <!-- Right Panel --> 
<!-- <?php
require_once 'include_admin/footer.php'; ?> -->