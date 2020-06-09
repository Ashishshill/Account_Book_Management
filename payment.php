<?php include 'init/header.php';

$errors = array();

try{
  $payment = new Payment();
  $payments = $payment->all();
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
        $payment = new Payment();

        try {
            $payment->delete(Input::get('delete'));
            Session::flash('payment', 'payment delete success!');
            Redirect::to('payment.php');
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
          <h1 class="h3 mb-2 text-gray-800">Payment</h1>
          <a class="btn btn-link" href="add_payment.php">Enter Payment</a>
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
                      <th>Payment Date</th>
                      <th>Ammount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Invoice Number</th>
                      <th>Payment Date</th>
                      <th>Ammount</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($payments as $pa): 
                      $in = new Invoice();
                      $in->find($pa->invoice_id);


                      ?>
                      <tr>
                        <td><?= $pa->invoice_id; ?></td>
                        <td><?= $pa->date; ?></td>
                        <td><?= $in->data()->total_price; ?></td>
                        <td>
                          <a class="btn btn-danger" href="?delete=<?= $pa->payment_id; ?>" onclick="return confirm('Are you sure you want to delete this Employee?');">Delete</a>
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