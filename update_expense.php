<?php include 'init/header.php';

// checking user has id
if (isset($_GET["id"])) {
    Session::put("expense_id", $_GET["id"]);
}

// session created or not 
if (!Session::exists("expense_id")) {
    Redirect::to('expense.php');
}

$expense = new Expense(); // crateing object
$expense->find($_GET["id"]); //findng employee

// chcking employee exist in database
if (!$expense->exists()) {
    Redirect::to('expense.php');
}

$errors = array();

$data = $expense->data(); // getting data from database


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
                'min' => 2,
                'max' => 64,
            ),
        ));
        
        if($validation->passed()) {
            try {
                $expense->update(array(
                    'expense_date'       => Input::get('date'),
                    'expense_category'   => Input::get('category'),
                    'expense_amount'     => Input::get('ammount'),
                    'expense_note'       => Input::get('note'),
                ), $data->expense_id);
                Session::flash('expense', 'expense update success!');
                Redirect::to('expense.php');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            $errors = $validation->errors();
        }
    }
}


?>


<div class="daa_product">
 <div class="container"> 
     <form method="post">
        <div class="form-row">
            <div class="col-6 form-group">
              <label for="category">Expense Category:</label>
              <input type="text" value="<?= $data->expense_category; ?>" class="form-control" id="category" placeholder="Expense Category" name="category">
            </div>
        </div>
        <div class="form-row">
            <div class="col-3 form-group">
              <label for="date">Date</label>
              <input type="date" value="<?= $data->expense_date; ?>" class="form-control" id="date" name="date">
            </div>
        </div>
        <div class="form-row">
            <div class="col-4 form-group">
              <label for="ammount">Ammount:</label>
              <input type="number" value="<?= $data->expense_amount; ?>" class="form-control" id="ammount" placeholder="Ammount" name="ammount">
            </div>
        </div>
        <div class="form-row">
            <div class="col-4 form-group">
              <label for="note">Expense Note</label>
              <input type="text" value="<?= $data->expense_note; ?>" class="form-control" id="note" placeholder="Note" name="note">
            </div>
        </div>

            <input type="hidden" name="token" value="<?php echo Token::generate();
    ?>" />
     <button type="submit" class="btn btn-success">Update Expense</button>
     </form>
 </div>
</div>  





<?php include 'init/footer.php' ?>