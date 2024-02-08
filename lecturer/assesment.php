<?php
session_start();

$pageTitle = "Assesment";
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

    <section class="section">
    <div class="row">
        <div class="col-lg-12">


  <div class="card">
            <div class="card-body">
<p></p>
              <!-- Vertically centered Modal -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
               ADD
              </button>
              <div class="modal fade" id="verticalycentered" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">



<!-- Modal Footer -->
<div class="modal-footer">      
    <button type="button" class="btn btn-primary" onclick="registerUser()">Register</button>

    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>

</div>
                </div>
              </div><!-- End Vertically centered Modal-->

            </div>
          </div>

      </div>
    </div>
      <div class="row">
        <div class="col-lg-12">

         


         
        <div class="card">
          <div class="card-body">
                  <h5 class="card-title">Assesment </h5>

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
  <script>
        // Function to filter rows based on user input
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName


            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                // Access the first cell in each row (assuming it's the one you want to filter)
                td = tr[i].getElementsByTagName("td")[0];

                if (td) {
                    txtValue = td.textContent || td.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Attach an event listener to the input for real-time filtering
        document.getElementById("searchInput").addEventListener("input", filterTable);
    </script>
</body>

</html>