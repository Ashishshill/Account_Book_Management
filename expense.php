<?php include 'init/header.php';

$errors = array();

try{
  $expense = new Expense();
  $expenses = $expense->all();
}  catch(Exception $e) {
    die($e->getMessage());
}
try{
  $employee = new Employee();
  $employees = $employee->all();
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
     $expense = new Expense();

        try {
            $expense->delete(Input::get('delete'));
            Session::flash('expense', 'Employee delete success!');
            Redirect::to('expense.php');
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
          <h1 class="h3 mb-2 text-gray-800">Expense</h1>
          <a class="btn btn-link" href="add_expense.php">Add Expense</a>
                                   
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
                      <th>Date</th>
                      <th>Category</th>
                      <th>Amount</th>
                      <th>Note</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Employee Name</th>
                      <th>Date</th>
                      <th>Category</th>
                      <th>Amount</th>
                      <th>Note</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($expenses as $em):

                      $ex = new Employee();
                      $ex->find($em->employee_id);
                     ?>
                      <tr>
                        <td><?= $ex->data()->employee_name ?></td>
                        <td><?= $em->expense_date; ?></td>
                        <td><?= $em->expense_category; ?></td>
                        <td><?= $em->expense_amount; ?></td>
                        <td><?= $em->expense_note; ?></td>
                        <td>
                          <a class="btn btn-success" href="update_expense.php?id=<?= $em->expense_id; ?>">Edit Expense</a>
                          <a class="btn btn-danger" href="?delete=<?= $em->expense_id; ?>" onclick="return confirm('Are you sure you want to delete this expenses?');">Delete</a>
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