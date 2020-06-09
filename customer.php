<?php include 'init/header.php';

$errors = array();

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
        $customer = new Customer();

        try {
            $customer->delete(Input::get('delete'));
            Session::flash('customer', 'Customer delete success!');
            Redirect::to('customer.php');
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
          <h1 class="h3 mb-2 text-gray-800">Customer</h1>
          <a class="btn btn-link" href="add_customer.php">Add Customer</a>
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
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($customers as $cu): ?>
                      <tr>
                        <td><?= $cu->customer_name; ?></td>
                        <td><?= $cu->customer_number; ?></td>
                        <td><?= $cu->customer_email; ?></td>
                        <td>
                          <a class="btn btn-primary" href="view_customer.php?id=<?= $cu->customer_id; ?>">view</a>
                          <a class="btn btn-success" href="update_customer.php?id=<?= $cu->customer_id; ?>">Update</a>
                          <a class="btn btn-danger" href="?delete=<?= $cu->customer_id; ?>" onclick="return confirm('Are you sure you want to delete this Employee?');">Delete</a>
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