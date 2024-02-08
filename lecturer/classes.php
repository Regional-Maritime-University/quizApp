<?php
session_start();

$pageTitle = "Classes";
?>
<!DOCTYPE html>
<html lang="en">

<?php include("need/head.php") ?>

<body>

  <!-- ======= Header ======= -->
  <?php include("need/header.php") ?>
<?php include("need/sidebar.php") ?>

  <main id="main" class="main">

  <?php include("need/pagetitle.php") ?>

    <section class="section"><div class="row">
        <div class="col-lg-12">


  <div class="card">
            <div class="card-body">
<p></p>
              <!-- Vertically centered Modal -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
               FILTER
              </button>
             
          </div>

      </div>
    </div>
     
      <div class="row">
        <div class="col-lg-12">
       <div class="card">
          <div class="card-body">
                  <h5 class="card-title">Classes </h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Course</th>
                        <th scope="col">Total Mark</th>                        
                        <th scope="col">Pass Mark</th> 
                        <th scope="col">Duration</th>
                        <th scope="col">Status</th>

                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">
                          <a href="#">#2457</a> <td>Brandon Jacob</td> <td>Brandon Jacob</td></th>
                        <td>Brandon Jacob</td>
                        <td><a href="#" class="text-primary">At praesentium minu</a></td>
                        <td>$64</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                     
                    </tbody>
                  </table>

                </div>
          </div>

          
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
 
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>