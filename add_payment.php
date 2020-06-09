<?php include 'init/header.php';

/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     echo "<pre>";
     var_dump($_POST);
     die;
}*/

try{
  $product = new Product();
  $products = $product->all();
}  catch(Exception $e) {
    die($e->getMessage());
}

try{
  $customer = new Customer();
  $customers = $customer->all();
}  catch(Exception $e) {
    die($e->getMessage());
}

try{
  $invoice = new Invoice();
  $invoices = $invoice->all();
}  catch(Exception $e) {
    die($e->getMessage());
}
// echo "<pre>";
// var_dump($products);

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            // 'payment_date' => array(
            //     'required' => true,
            //     'min' => 2,
            //     'max' => 64,
            // ),
        ));
        
        if($validation->passed()) {
            $payment = new Payment();

            try {
                $payment->create(array(
                    'date'          => date('Y-m-d H:i:s'),
                    'customer_id'   => input::get('customer'),
                    'invoice_id'    => input::get('product'),
                ));
                $invoice->find(input::get('product'));
                $invoice->update(array(
                  "status"  => "Paid"
                ), input::get('product'));
                Session::flash('invoice', 'Invoice added success!');
                Redirect::to('paymentConfirm.php?price=' . $invoice->data()->total_price . "&id=" . input::get('product'));
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
        <div class="form-row">

            <div class="col-3 form-group">
              <label for="product">Invoice Id:</label>
              <select name="product" id="product" class="form-control">
                    <?php if (!empty($invoices)): ?>
                        <option selected="selected" disabled>Please select Invoice</option>
                        <?php foreach ($invoices as $pro): ?>
                          <?php if ($pro->status != "Paid"): ?>
                            <option value="<?= $pro->invoice_id ?>" data-price="<?= $pro->invoice_id ?>"><?= $pro->invoice_id ?></option>
                            
                          <?php endif ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <option value="2" disabled>Please Create product</option>
                    <?php endif ?>
              </select>
            </div> 
        </div>
        <div class="form-row">
        <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
           <div class="col-3"> 
          <input type="submit" class="btn btn-primary btn-block" value="Payment Now">
          </div>
        </div>
     </form>
 </div>
</div>  


<?php include 'init/footer.php' ?>

<script>
    $(document).ready(function() {
        $('#quentity').change(function(){
            var price = $("#unit_cost").val();
            $("#total").val(price * $("#quentity").val());
        });

        $('#product').change(function(){
            var price = $(this).find(':selected').attr('data-price');

            $("#unit_cost").val(price);
            $("#total").val(price * $("#quentity").val());
        });
    });
</script>