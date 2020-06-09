<?php include 'init/header.php';

$errors = array();

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
        $employee = new Employee();

        try {
            $employee->delete(Input::get('delete'));
            Session::flash('employee', 'Employee delete success!');
            Redirect::to('employee.php');
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
          <h1 class="h3 mb-2 text-gray-800">Employee</h1>
          <a class="btn btn-link" href="add_employee.php">Add Employee</a>
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
                      <th>Position</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Salary</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Salary</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($employees as $em): ?>
                      <tr>
                        <td><?= $em->employee_name; ?></td>
                        <td><?= $em->employee_position; ?></td>
                        <td><?= $em->employee_email; ?></td>
                        <td><?= $em->employee_phone; ?></td>
                        <td><?= $em->employee_salary; ?></td>
                        <td>
                          <a class="btn btn-primary" href="view_employee.php?id=<?= $em->employee_id; ?>">view</a>
                          <a class="btn btn-success" href="update_employee.php?id=<?= $em->employee_id; ?>">Update</a>
                          <a class="btn btn-danger" href="?delete=<?= $em->employee_id; ?>" onclick="return confirm('Are you sure you want to delete this Employee?');">Delete</a>
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