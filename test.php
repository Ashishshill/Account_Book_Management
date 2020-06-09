<?php require_once 'core/init.php';
$employee = new Employee();

// for delete
try {
    $employee->delete(1);
    Session::flash('employee', 'Employee delete success!');
    Redirect::to('employee.php');
} catch(Exception $e) {
    die($e->getMessage());
}




// for list
// echo "<pre>";
// try{
//   var_dump($employee->all());
// }  catch(Exception $e) {
//     die($e->getMessage());
// }

// for crate
// try {
//     $employee->create(array(
//         'employee_name'  => "name",
//         'employee_nid'    => "nid",
//         'employee_phone'    => "phone",
//         'employee_email'    => "email",
//         'employee_dob'    => "oasd",
//         'employee_address'    => "asdf",
//         'employee_nationality'    => "asdf",
//         'employee_salary'    => "asdf",
//         'employee_position'    => "asdf",
//     ));
//     Session::flash('employee', 'Employee added success!');
//     Redirect::to('employee.php');
// } catch(Exception $e) {
//     die($e->getMessage());
// }

