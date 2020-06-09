<?php
require_once 'init/header.php'; 

?>
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>
          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          
          <div class="row">
<script>
window.onload = function () {

//Better to construct options first and then pass it as a parameter
var options = {
  animationEnabled: true,
  title: {
    text: "baler phone company",                
    fontColor: "Peru"
  },  
  axisY: {
    tickThickness: 0,
    lineThickness: 0,
    valueFormatString: " ",
    gridThickness: 0                    
  },
  axisX: {
    tickThickness: 0,
    lineThickness: 0,
    labelFontSize: 18,
    labelFontColor: "Peru"        
  },
  data: [{
    indexLabelFontSize: 26,
    toolTipContent: "<span style=\"color:#62C9C3\">{indexLabel}:</span> <span style=\"color:#CD853F\"><strong>{y}</strong></span>",
    indexLabelPlacement: "inside",
    indexLabelFontColor: "white",
    indexLabelFontWeight: 600,
    indexLabelFontFamily: "Verdana",
    color: "#62C9C3",
    type: "bar",
    dataPoints: [
      { y: 21, label: "21%", indexLabel: "asdf" },
      { y: 25, label: "25%", indexLabel: "Dining" },
      { y: 33, label: "33%", indexLabel: "Entertainment" },
      { y: 36, label: "36%", indexLabel: "News" },
      { y: 42, label: "42%", indexLabel: "Music" },
      { y: 49, label: "49%", indexLabel: "Social Networking" },
      { y: 50, label: "50%", indexLabel: "Maps/ Search" },
      { y: 55, label: "55%", indexLabel: "Weather" },
      { y: 61, label: "61%", indexLabel: "Games" }
    ]
  }]
};

$("#barChart").CanvasJSChart(options);
}
</script>

            <div id="barChart" style="height: 370px; width: 100%;"></div>
            <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>

<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
          </div>

        </div>
        <!-- /.container-fluid -->
<?php include 'init/footer.php' ?>

