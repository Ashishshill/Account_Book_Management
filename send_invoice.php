<?php
require_once 'dompdf/autoload.inc.php';
require_once("core/init.php");

// checking user has id
if (isset($_GET["id"])) {
    Session::put("invoice_id", $_GET["id"]);
}
if (isset($_GET["email"])) {
    Session::put("send_email", $_GET["email"]);
}

// session created or not 
if (!Session::exists("invoice_id")) {
    Redirect::to('invoice.php');
}

$db = DB::getInstance();
$db->query("SELECT * FROM invoices AS i, customers AS c, invoice_product AS ip, products AS p WHERE i.customer_id = c.customer_id AND ip.invoice_id = i.invoice_id AND ip.product_id = p.product_id AND i.invoice_id = 4 LIMIT 1", array(Session::get("invoice_id")));
$whole_in_data = $db->first();

$message = '';

function fetch_customer_data(){
	global $whole_in_data;
	$output = '
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<tr>
				<th>Invoice Number</th>
				<th>Invoice Date</th>
				<th>Due Date</th>
				<th>Customer Name</th>
				<th>Total Price</th>
			</tr>
			<tr>
				<td>' . $whole_in_data->invoice_id . '</td>
				<td>' . $whole_in_data->invoice_date . '</td>
				<td>' . $whole_in_data->due_date . '</td>
				<td>' . $whole_in_data->customer_name . '</td>
				<td>' . $whole_in_data->total_price . '</td>
			</tr>
		</table>
	</div>';
	return $output;
}

	$pdf = new Pdf();


	$file_name = md5(rand()) . '.pdf';
	$html_code = '<link rel="stylesheet" href="bootstrap.min.css">';
	$html_code .= fetch_customer_data();
	$pdf->load_html($html_code);
	$pdf->render();
	$file = $pdf->output();
	file_put_contents($file_name, $file);
	
	require 'classes/class.phpmailer.php';
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

				
				$mail->addAddress(Session::get("send_email"), 'Joe User');     // Add a recipient

				$mail->Subject = 'Here is the subject';
				$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';				//An HTML or plain text message body
	if($mail->Send())								//Send an Email. Return true on success or false on error
	{
		$message = '<label class="text-success">Customer Details has been send successfully...</label>';
	}
	unlink($file_name);

Redirect::to('view_invoice.php?id=' . Session::get("invoice_id"));
