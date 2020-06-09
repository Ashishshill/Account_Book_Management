<?php include 'init/header.php';

$errors = array();

try{
  $invoice = new Invoice();
  $invoices = $invoice->all();
}  catch(Exception $e) {
    die($e->getMessage());
}
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


if(Input::exists("get")) {
    $validate = new Validate();
    $validation = $validate->check($_GET, array(
        'delete' => array(
            'required' => true
        )
    ));
    
    if($validation->passed()) {
        $invoice = new Invoice();

        try {
            $invoice->delete(Input::get('delete'));
            Session::flash('invoice', 'Invoice delete success!');
            Redirect::to('invoice.php');
        } catch(Exception $e) {
            die($e->getMessage());
        }
    } else {
      $errors = $validation->errors();
    }
}
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Invoice</h1>
          <a class="btn btn-link" href="add_invoice_main.php">Add Invoice</a>
          <?php if (!empty($errors)): ?>
            <?php foreach ($validation->errors() as $error): ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <?= $error; ?>
                </div>
            <?php endforeach ?>
          <?php endif ?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"> Details</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Invoice Number</th>
                      <th>Customer Name</th>
                      <th>Date</th>
                      <th>Ammount</th>
                      <th>Due Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead> 
                  <tfoot>
                    <tr>
                      <th>Invoice Number</th>
                      <th>Customer Name</th>
                      <th>Date</th>
                      <th>Ammount</th>
                      <th>Due Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>

                  <tbody>
                    <?php foreach ($invoices as $in): 
                      $cu = new Customer();
                      $cu->find($in->customer_id);
                      $pay = new Payment();
                      $pay->invoice($in->invoice_id);

                      ?>
                      <tr>
                        <td><?= $in->invoice_id; ?></td>
                        <td><?= $cu->data()->customer_name ?></td>
                        <td><?= $in->invoice_date; ?></td>
                        <td><?= $in->total_price; ?></td>
                        <td><?= $in->due_date; ?></td>
                        <td>

                          <?php 
                            if ($pay->data()) {
                              echo "Paid";
                            } else{
                              echo "Due";
                            }
                          ?>
                            
                         </td>
                        <td>
                          <a class="btn btn-primary" href="view_Invoice.php?id=<?= $in->invoice_id; ?>">view</a>
                          <a class="btn btn-danger" href="?delete=<?= $in->invoice_id; ?>" onclick="return confirm('Are you sure you want to delete this Invoice?');">Delete</a>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      
<?php include 'init/footer.php' ?>