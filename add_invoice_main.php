<?php include 'init/header.php';


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//      echo "<pre>";
//      var_dump($_POST);
//      die;
// }

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
            'total' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
        ));
        
        for($i = 0; $i<count($_POST["subtotal"]); $i++){

            $product->find($_POST["product"][$i]);

            if ($_POST["quentity"][$i] > $product->data()->product_qnt) {
                $validation->addError($product->data()->product_name . " Out of stock");
            }
        }
        if($validation->passed()) {
            $invoice = new Invoice();
            $invoice_pro = new Invoice_pro();

            try {
                $invoice_id = $invoice->create(array(
                    'invoice_date'  => date('Y-m-d H:i:s'),
                    'due_date'    => date('Y-m-d H:i:s'),
                    'total_price'    => input::get('total'),
                    'customer_id'    => input::get('customer'),
                ));
                for($i = 0; $i<count($_POST["subtotal"]); $i++){
                    $data = array(
                        'product_id'    => $_POST["product"][$i],
                        'unit_cost'     => $_POST["unit_cost"][$i],
                        'quantity'      => $_POST["quentity"][$i],
                        'subtotal'      => $_POST["subtotal"][$i],
                        'invoice_id'    => $invoice_id,
                    );
                    $invoice_pro->create($data);

                    $product->find($_POST["product"][$i]);
                    $total_quentity = $product->data()->product_qnt - $_POST["quentity"][$i];

                    $product->update(array(
                        'product_qnt'     => $total_quentity,
                    ), $_POST["product"][$i]);
                }

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
        <div class="form-row">
            <div class="col-6 form-group">
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
        </div>
        <div class="form-row">
            <div class="col-3 form-group">
              <label for="invoice_date">Invoice Date:</label>
              <input type="date" class="form-control" id="invoice_date" name="invoice_date">
            </div>
            <div class="col-3 form-group">
              <label for="due_date">Due Date:</label>
              <input type="date" class="form-control" id="due_date" name="due_date">
            </div> 
        </div> 
            <div class="form-group">
              <button class="btn btn-primary" id="add_product" type="button">Add product</button>
            </div>  

            <div id="invoice_product">
                <div class="invoice_whole_product row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="product">Prouct Name:</label>
                          <select name="product[]" id="product" class="form-control product">
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
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="unit_cost">Unit Cost:</label>
                          <input type="number" class="form-control unit_cost" value="0" name="unit_cost[]" readonly="readonly">
                        </div>                        
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="quentity">Quentity:</label>
                          <input type="number" class="form-control quentity" value="1" name="quentity[]" min="1" max="10">
                        </div>                        
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="subtotal">Subtotal:</label>
                          <input type="number" class="form-control subtotal" value="0" name="subtotal[]" readonly="readonly">
                        </div>                        
                    </div>
                    <div class="col-md-1">
                        <br>
                        <button type="button" class="delete btn btn-danger">Delete</button>
                    </div>
                </div>                
            </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="total">Total:</label>
              <input type="text" class="form-control" id="total" placeholder="Total" name="total" readonly="readonly">
            </div>
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
        var max_fields = 10;
        var wrapper = $("#invoice_product");
        var add_button = $("#add_product");
        var html_products = $("div.invoice_whole_product").html();

        var x = 1;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="invoice_whole_product row">' + html_products + "</div>"); //add input box
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').parent('div').remove();
            x--;
        });

        $(wrapper).on('change','.product', function(e){
            e.preventDefault();
            $(this)
                .parent('div')
                .parent('div')
                .parent('div').
                children('div.col-md-2')
                .children("div.form-group")
                .children("input.unit_cost")
                .val(
                    $(this).find(':selected').attr('data-price')
                );
            $(this)
                .parent('div')
                .parent('div')
                .parent('div').
                children('div.col-md-2')
                .children("div.form-group")
                .children("input.quentity")
                .val(1);
            $(this)
                .parent('div')
                .parent('div')
                .parent('div').
                children('div.col-md-2')
                .children("div.form-group")
                .children("input.subtotal")
                .val(
                    $(this).find(':selected').attr('data-price')
                );
        });

        $(wrapper).on('change','.quentity', function(e){
            e.preventDefault();
            var quentity = $(this)
                .parent('div')
                .parent('div')
                .parent('div').
                children('div.col-md-2')
                .children("div.form-group")
                .children("input.quentity")
                .val();
            var unit_cost = $(this)
                .parent('div')
                .parent('div')
                .parent('div').
                children('div.col-md-2')
                .children("div.form-group")
                .children("input.unit_cost")
                .val();
            var subtotal = unit_cost * quentity;
            $(this)
                .parent('div')
                .parent('div')
                .parent('div').
                children('div.col-md-2')
                .children("div.form-group")
                .children("input.subtotal")
                .val(subtotal);
            var t = calculate_total($(".subtotal"));
            $("#total").val(t);
        });
    });
    function calculate_total(someArray){
        var total = 0;
        for (var i = 0; i < someArray.length; i++) {
            total += someArray[i].value << 0;
        }
        return total
    }
</script>