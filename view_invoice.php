<?php include 'init/header.php';



try{
  $customer = new Customer();
  $customers = $customer->all();
}  catch(Exception $e) {
    die($e->getMessage());
}
try{
  $invoice_pro = new Invoice_pro();
  $invoice_pros = $invoice_pro->all();
}  catch(Exception $e) {
    die($e->getMessage());
}
// checking user has id
if (isset($_GET["id"])) {
    Session::put("invoice_id", $_GET["id"]);
}

// session created or not 
if (!Session::exists("invoice_id")) {
    Redirect::to('invoice.php');
}

$invoice = new Invoice(); // crateing object
$invoice->find($_GET["id"]); //findng employee

// chcking employee exist in database
if (!$invoice->exists()) {
    Redirect::to('invoice.php');
}

$data = $invoice->data(); // getting data from database

// echo "<pre>";
// var_dump($data);
// die;

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css"/>


<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-title mb-4">
                            <div class="d-flex justify-content-start">
                                <div class="userData ml-3">
                                    <label style="font-weight:bold;">Invoice Number</label>
                                    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascript:void(0);"><?= $data->invoice_id; ?></a></h2>
                                </div>
                                <div class="ml-auto">
                                    <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                        
                                    <?php foreach ($invoice as $in):  
                                          $cu = new Customer();
                                          $cu->find($in->customer_id); ?>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Customer Name</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p value="<?= $cu->data()->customer_name ?>"><?= $cu->customer_name ?></p>
                                            </div>
                                        </div>
                                        <hr />
                                    <?php endforeach ?>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Invoice Date</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $data->invoice_date; ?>
                                            </div>
                                        </div>
                                        <hr />
                                        
                                        
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Due Date</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $data->due_date; ?>
                                            </div>
                                        </div>
                                        <hr />
                                    <?php foreach 
                                            ($invoice_pros as $po ): 
                                            $pro = new Product();
                                            $pro->find($po->product_id);

                                            ?>
                                            <?php if ($data->invoice_id == $po->invoice_id): ?>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Product Name <br> Price <br></label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <p value="<?= $po->product_id ?>"><?= $pro->data()->product_name ?><br><?= $pro->data()->product_price ?></p>
                                            </div>
                                        </div>
                                                
                                            <?php endif ?>
                                    <?php endforeach ?>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Total Price</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $data->total_price; ?>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Status</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?= $data->due_date; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a class="btn btn-success" href="dawonload.php?id=<?= Session::get("invoice_id"); ?> ">Dawonload Invoice</a>          
                            <a class="btn btn-success" href="sendpdf.php?id=<?= Session::get("invoice_id"); ?>">Send Invoice</a>          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include 'init/footer.php' ?>