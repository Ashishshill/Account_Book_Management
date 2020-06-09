 <?php include 'init/header.php';
    $db = DB::getInstance();
    $sale_product = $db->query("SELECT COUNT(*) AS sale_product, p.product_name FROM invoices as i, invoice_product as ip, products as p WHERE p.product_id = ip.product_id and ip.invoice_id = i.invoice_id GROUP BY p.product_category")->results();

    $income = $db->query("SELECT SUM(i.total_price) AS price FROM invoices AS i, payments AS p WHERE i.invoice_id = p.invoice_id AND p.status = 'paid' AND p.date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->results()[0]->price;
    $expense = $db->query("SELECT SUM(expenses.expense_amount) AS price FROM expenses WHERE expenses.expense_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->results()[0]->price;

    $due = $db->query("SELECT SUM(i.total_price) AS price FROM invoices AS i, payments AS p WHERE i.invoice_id = p.invoice_id AND p.status = '' AND i.invoice_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->results()[0]->price;

    if ($income == Null) {
      $income = 0;
    }

    if ($expense == Null) {
      $expense = 0;
    }

    if ($due == Null) {
      $due = 0;
    }

 ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Reports</h1>
          

<script>
window.onload = function () {
  
var expense_income = new CanvasJS.Chart("expense_income", {
  animationEnabled: true,
  
  title:{
    text:"Yearly Reports "
  },
  axisX:{
    interval: 1
  },
  axisY2:{
    interlacedColor: "rgba(1,77,101,.2)",
    gridColor: "rgba(1,77,101,.1)",
  },
  data: [{
    type: "bar",
    name: "companies",
    axisYType: "secondary",
    color: "#014D65",
    dataPoints: [
      { y: <?= $expense; ?>, label: "expense" },
      { y: <?= $income; ?>, label: "income" },
      { y: <?= $due; ?>, label: "due" },
    ]
  }]
});
expense_income.render();



var sale_product = new CanvasJS.Chart("sale_product", {
    animationEnabled: true,
    title:{
        text: "Highest Sale Product"
    },
    axisY:{
        title: "Highest Sale Product"
    },
    toolTip: {
        shared: true
    },
    data: [{
        type: "column",
        name: "Avg. Lifespan",
        toolTipContent: "{label} <br> <b>{name}:</b> {y} years",
        dataPoints: [
        <?php foreach ($sale_product as $area): ?>
             { y: <?= $area->sale_product; ?>, label: '<?= $area->product_name; ?>' },
        <?php endforeach ?>
        ]
    },]
});
sale_product.render();
}
</script>


<div class="row">
  <div class="col-md-6">
    <div id="expense_income" style="height: 370px; width: 100%;"></div>
  </div>
  <div class="col-md-6">
    <div id="sale_product" style="height: 370px; width: 100%;"></div>
  </div>
</div>





















        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->

  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
