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
// echo "<pre>";
// var_dump($products);

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            // 'customer' => array(
            //     'required' => true,
            //     'min' => 2,
            //     'max' => 64,
            // ),
            'invoice_date' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'due_date' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            // 'product' => array(
            //     'required' => true,
            //     'min' => 2,
            //     'max' => 128,
            // ),
            // 'unit_cost' => array(
            //     'required' => true,
            //     'min' => 2,
            //     'max' => 64,
            // ),
            'quentity' => array(
                'required' => true,
                'max' => 255,
            ),
            'total' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
        ));
        
        if($validation->passed()) {
            $invoice = new Invoice();

            try {
                $invoice->create(array(
                    'invoice_date'  => date('Y-m-d H:i:s'),
                    'due_date'    => date('Y-m-d H:i:s'),
                    'total_price'    => input::get('total'),
                    'customer_id'    => input::get('customer'),
                    'product_id'    => input::get('product'),
                    'quentity'    => input::get('quentity'),
                ));
                Session::flash('invoice', 'Invoice added success!');
                Redirect::to('invoice.php');
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
            <div class="form-group">
              <label for="name">Customer Full Name:</label>
              <select name="customer" id="customer" class="form-control">
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $pro): ?>
                        <option value="<?= $pro->customer_id ?>"><?= $pro->customer_name ?></option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option value="2" disabled>Please Create customers</option>
                <?php endif ?>
              </select>
            </div>
            <div class="form-group">
              <label for="invoice_date">Invoice Date:</label>
              <input type="date" class="form-control" id="invoice_date" name="invoice_date">
            </div>
            <div class="form-group">
              <label for="due_date">Due Date:</label>
              <input type="date" class="form-control" id="due_date" name="due_date">
            </div> 

            <div class="form-group">
              <label for="product">Prouct Name:</label>
              <select name="product" id="product" class="form-control">
                    <?php if (!empty($products)): ?>
                        <option selected="selected" disabled>Please select product</option>
                        <?php foreach ($products as $pro): ?>
                            <option value="<?= $pro->product_id ?>" data-price="<?= $pro->product_price ?>"><?= $pro->product_name ?></option>
                        <?php endforeach ?>
                    <?php else: ?>
                        <option value="2" disabled>Please Create product</option>
                    <?php endif ?>
              </select>
            </div>                   
            <div class="form-group">
              <label for="unit_cost">Unit Cost:</label>
              <input type="number" class="form-control" value="1" name="unit_cost" id="unit_cost"  readonly="readonly">
            </div>                        
            <div class="form-group">
              <label for="quentity">Quentity:</label>
              <input type="number" class="form-control" value="1" name="quentity" id="quentity">
            </div>                        
            <div class="form-group">
              <label for="total">Total:</label>
              <input type="text" class="form-control" id="total" placeholder="Total" name="total" readonly="readonly">
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
            <button type="submit" class="btn btn-success">Submit</button>
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