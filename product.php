<?php include 'init/header.php';

$errors = array();

try{
  $product = new Product();
  $products = $product->all();
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
        $product = new Product();

        try {
            $product->delete(Input::get('delete'));
            Session::flash('product', 'Product delete success!');
            Redirect::to('product.php');
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
          <h1 class="h3 mb-2 text-gray-800">Product</h1>
          <a class="btn btn-link" href="add_product_check.php">Add Product</a>
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
                      <th>Product Name</th>
                      <th>Product Details</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Category</th>
                      <th>Action</th>
                    </tr>
                  </thead> <tfoot>
                    <tr>
                      <th>Product Name</th>
                      <th>Product Details</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Category</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                    <tbody>
                    <?php foreach ($products as $pr): ?>
                      <tr>
                        <td><?= $pr->product_name; ?></td>
                        <td><?= $pr->product_details; ?></td>
                        <td><?= $pr->product_price; ?></td>
                        <td><?= $pr->product_qnt; ?></td>
                        <td><?= $pr->product_category; ?></td>
                        <td><!-- Dont need View product
                          <a class="btn btn-primary" href="view_product.php?id=<?= $pr->product_id; ?>">view</a> -->
                          <a class="btn btn-success" href="update_product.php?id=<?= $pr->product_id; ?>">Update</a>
                          <a class="btn btn-danger" href="?delete=<?= $pr->product_id; ?>" onclick="return confirm('Are you sure you want to delete this Employee?');">Delete</a>
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