<?php
session_start();

include("dataconn.php");

$pageTitle = "Quizzes";
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
<p>

</p>
              <!-- Vertically centered Modal -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
               ADD
              </button>
              
<!-- Button to open the filter modal -->
              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
               FILTER
              </button>


<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Quizzes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="statusDropdown" class="form-label">Select Status</label>
                        <select class="form-select" id="statusDropdown" name="statusDropdown">
                            <option value="all" selected>All</option>
                            <option value="assigned">Assigned</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <!-- You can add more filter options based on your requirements -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Quiz Modal -->
<div class="modal fade" id="verticalycentered" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addQuizForm">
                    <div class="mb-3">
                        <label for="quizTitle" class="form-label">Quiz Title</label>
                        <input type="text" class="form-control" id="quizTitle" name="quizTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizDescription" class="form-label">Quiz Instruction</label>
                        <textarea class="form-control" id="quizDescription" name="quizDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="courseDropdown" class="form-label">Select Course</label>
                        <select class="form-select" id="courseDropdown" name="courseDropdown" required>
                            <option value="" selected disabled>Choose...</option>
                            <!-- Replace these with actual courses -->
                            <option value="C001">Course 1</option>
                            <option value="C002">Course 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quizDate" class="form-label">Quiz Date</label>
                        <input type="date" class="form-control" id="quizDate" name="quizDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizTime" class="form-label">Quiz Time</label>
                        <input type="time" class="form-control" id="quizTime" name="quizTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizDuration" class="form-label">Quiz Duration (minutes)</label>
                        <input type="number" class="form-control" id="quizDuration" name="quizDuration" required>
                    </div>
                    <input type="hidden" id="fk_staff"name="fk_staff"value="10001">    
                    <input type="hidden" id="fk_semester" name="fk_semester" value="1">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitQuizForm()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Your Custom JS -->
<script>
    function applyFilters() {
        $('#filterModal').modal('hide');
        fetchFilteredQuizzes();
    }

    $(document).ready(function() {
        $("#filterButton").on("click", function() {
            $("#filterModal").modal("show");
        });

        $("#statusDropdown").on("change", function() {
            fetchFilteredQuizzes();
        });

        $("#addQuizBtn").on("click", function() {
            $("#verticalycentered").modal("show");
        });

        $("#submitQuizBtn").on("click", function() {
            submitQuizForm();
        });
    });

   

    function submitQuizForm() {
    // Assuming you have a form with id "addQuizForm"
    var formData = $("#addQuizForm").serialize(); // Serialize form data

    $.ajax({
        type: "POST",
        url: "api/getQuiz", // Replace with your actual server endpoint
        data: formData,
        success: function(data) {
            // Handle the response from the server
            console.log(data);
            alert('Quiz added successfully!');
            $('#verticalycentered').modal('hide');
        },
        error: function(error) {
            // Handle errors
            console.error(error);
            alert('Failed to add quiz!');
        }
    });
    }


function fetchFilteredQuizzes() {
    var selectedStatus = $("#statusDropdown").val();

    // Assuming you have a div with id "quizList" to display the quizzes
    var quizListContainer = $("#quizList");

    $.ajax({
        type: "GET",
        url: "api", // Replace with your actual server endpoint
        data: { status: selectedStatus },
        success: function(data) {
            // Handle the response from the server
            console.log(data);

            // Assuming your server returns HTML or JSON with quiz data
            // Update the quizListContainer with the fetched data
            quizListContainer.html(data);

            // Close the filter modal after fetching quizzes
            $('#filterModal').modal('hide');
        },
        error: function(error) {
            // Handle errors
            console.error(error);
            alert('Failed to fetch filtered quizzes!');
        }
    });
}

</script>

              <!-- <div class="modal fade" id="verticalycentered" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addQuizForm">
                    <div class="mb-3">
                        <label for="quizTitle" class="form-label">Quiz Title</label>
                        <input type="text" class="form-control" id="quizTitle" name="quizTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizInstructions" class="form-label">Quiz Instructions</label>
                        <textarea class="form-control" id="quizInstructions" name="quizInstructions" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="courseDropdown" class="form-label">Select Course</label>
                        <select class="form-select" id="courseDropdown" name="courseDropdown" required>
                            <option value="" selected disabled>Choose...</option>
                            <option value="course1">Course 1</option>
                            <option value="course2">Course 2</option>
                            <option value="course3">Course 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quizDate" class="form-label">Quiz Date</label>
                        <input type="date" class="form-control" id="quizDate" name="quizDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizTime" class="form-label">Quiz Time</label>
                        <input type="time" class="form-control" id="quizTime" name="quizTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizDuration" class="form-label">Quiz Duration (minutes)</label>
                        <input type="number" class="form-control" id="quizDuration" name="quizDuration" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitQuizForm()">Save changes</button>
            </div>
        </div>
    </div>
</div> -->

<script>
   
</script>
<!-- End Vertically centered Modal-->

            </div>
          </div>

      </div>
    </div>

      <div class="row">
        <div class="col-lg-12">

         

    <div class="card">
          <div class="card-body">
                  <h5 class="card-title">Quizzes </h5>
                  <?php
// Select query for the quizzes table
$staffId = $quiz['fk_staff']; // Assuming $quiz['fk_staff'] contains the specific staff ID
$sqlQuiz = "SELECT * FROM quizz WHERE fk_staff = :staffId";
$stmtQuiz = $pdo->prepare($sqlQuiz);
$stmtQuiz->bindParam(':staffId', $staffId, PDO::PARAM_STR);
$stmtQuiz->execute();
$quizzes = $stmtQuiz->fetchAll(PDO::FETCH_ASSOC);
?>

      <table class="table table-borderless datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Course</th>
            <th scope="col">Start Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">Duration</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($quizzes as $index => $quiz) : ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= $quiz['title'] ?></td>
                <td><?= $quiz['fk_course'] ?></td>
                <td><?= $quiz['start_date'] ?></td>
                <td><?= $quiz['start_time'] ?></td>
                <td><?= $quiz['duration'] ?></td>
                <td><?= $quiz['fk_semester'] ?></td>
            </tr>
        <?php endforeach; ?>
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
  <!-- <script>
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
    </script> -->
</body>

</html>