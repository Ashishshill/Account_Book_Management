<?php include 'init/header.php';


try{
  $employee = new Employee();
  $employees = $employee->all();
}  catch(Exception $e) {
    die($e->getMessage());
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'date' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'category' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
            'ammount' => array(
                'required' => true,
                'min' => 2,
                'max' => 128,
            ),
            'note' => array(
                'required' => true,
                'min' => 2,
                'max' => 64,
            ),
        ));
        
        if($validation->passed()) {
            $expense = new Expense();

            try {
                $expense->create(array(
                    'expense_date'       => Input::get('date'),
                    'expense_category'   => Input::get('category'),
                    'expense_amount'     => Input::get('ammount'),
                    'expense_note'       => Input::get('note'),
                    'expense_billing'    => Input::get('billing'),
                    'employee_id'        => Input::get('employee_name'),
                ));
                Session::flash('expense', 'expense added success!');
                Redirect::to('expense.php');
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
<div class="daa_expense">
 <div class="container"> 
  	 <form method="post" data-toggle="validator">
        <div class="form-row">
            <div class="col-3 form-group">
              <label for="name">Employee Full Name:</label>
              <select name="employee_name" id="name" class="form-control">
                <?php if (!empty($employees)): ?>
                    <?php foreach ($employees as $pro): ?>
                        <option value="<?= $pro->employee_id ?>"><?= $pro->employee_name ?></option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option value="2" disabled>Please Create Employee</option>
                <?php endif ?>
              </select>
            </div>

            <div class="col-3 form-group">
              <label for="date">Date</label>
              <input type="date" class="form-control" id="date" name="date">
            </div>
        </div>
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="category">Expense Category:</label>
              <input type="text" pattern="^[_A-z ]{1,}$" class="form-control" id="category" placeholder="Expense Category" name="category">

            </div>
        </div>
        <div class="form-row">
            <div class="col-4 form-group">
              <label for="ammount">Amount:</label>
              <input type="ammount" class="form-control" id="ammount" placeholder="Ammount" name="ammount">
            </div>
        </div>
        <div class="form-row">
            <div class="col-4 form-group">
              <label for="note">Expense Note</label>
              <textarea type="text" pattern="^[_A-z 0-9]{1,}$" class="form-control" id="note" placeholder="Expanse Note" name="note"></textarea>
            </div>
        </div>

		    <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     <button type="submit" class="btn btn-success">Add Expense</button>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>


<script type="text/javascript">
    $("#ammount").inputFilter(function (value) {
        return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200000);
    });
</script>