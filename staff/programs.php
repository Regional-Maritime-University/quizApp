<?php
session_start();

require("../bootstrap.php");

use Core\Base;
use Controller\Programs;

$config = require Base::build_path("config/database.php");

$pageTitle = "Programs";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require Base::build_path("partials/head.php") ?>
</head>

<body>

    <?php require Base::build_path("partials/header.php") ?>

    <?php require Base::build_path("partials/aside.php") ?>

    <main id="main" class="main">

        <?php require Base::build_path("partials/page-title.php") ?>

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row mb-4">
                        <!-- Add new lectuer modal -->
                        <div class="col-xxl-12 col-md-12">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addNewLecturer">Add</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Programs</h5>
                                    <!-- Bordered Table -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Program Code</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Duration</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $programs = new Programs($config["database"]["mysql"]);
                                            $all_programs = $programs->fetchByDepartment($_SESSION["user"]["fk_department"]);

                                            $counter = 1;
                                            foreach ($all_programs as $programs) :
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $counter ?></th>
                                                    <td><?= $programs["programCode"] ?></td>
                                                    <td><?= $programs["programName"] ?></td>
                                                    <td><?= trim($programs["programDuration"] . " " . $programs["durationFormat"]) ?></td>

                                                    <td style="display: flex;">
                                                        <button type="button" class="btn btn-primary btn-sm me-2 editprogramData" data-program="<?= $programs["programCode"] ?>" data-bs-toggle="modal" data-bs-target="#editProgram">Edit</button>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="program" value="<?= $programs["programCode"] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm">Archive</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                                $counter++;
                                            endforeach
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- End Bordered Table -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Left side columns -->
            </div><!-- End Left side columns -->

            </div>
        </section>

        <!-- Add new lecturer modal -->
        <div class="modal fade" id="addNewProgram" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add new Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">
                        <div style="display: flex; width:600px">
                            <!-- Multi Columns Form -->
                            <form id="addNewProgForm" class="row g-3" method="POST">
                                <div class="col-md-4">
                                    <label for="add-prog-prefix" class="form-label">Prefix</label>
                                    <select name="add-prog-prefix" id="add-prog-prefix" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="add-prog-fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="add-prog-fname" name="add-prog-fname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="add-prog-mname" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="add-prog-mname" name="add-prog-mname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="add-prog-lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="add-prog-lname" name="add-prog-lname" value="">
                                </div>
                                <div class="col-md-8">
                                    <label for="add-prog-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="add-prog-email" name="add-prog-email" value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="add-prog-role" class="form-label">Role</label>
                                    <select id="add-prog-role" name="add-prog-role" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option value="lecturer">LECTURER</option>
                                        <option value="hod">HOD</option>
                                        <option value="secretary">SECRETARY</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <div class="form-check">
                                        <input type="radio" name="add-prog-gender" id="maleGender" class="form-check-input" value="M">
                                        <label for="maleGender" class="form-check-label">M</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="add-prog-gender" id="femaleGender" class="form-check-input" value="F">
                                        <label for="femaleGender" class="form-check-label">F</label>
                                    </div>
                                </div>
                                <input type="hidden" name="add-prog-depart" value="<?= $_SESSION["user"]["fk_department"] ?>">
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="add-lecturer" id="addNewProgBtn">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->

        <?php
        // if (isset($_GET["number"]) && !empty($_GET["number"])) :

        //     $programs = new Lecturers($config["database"]["mysql"]);
        //     $all_lecturers = $lecturers->fetchByDepartment($_SESSION["user"]["fk_department"]);

        //     $counter = 1;
        //     foreach ($all_lecturers as $lecturer) :

        ?>
        <!-- Edit Lectuer modal -->
        <div class="modal fade" id="editProgram" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">

                        <div style="display: flex; width:600px">
                            <!-- Multi Columns Form -->
                            <form class="row g-3">
                                <div class="col-md-8">
                                    <label for="edit-prog-fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="edit-prog-fname" name="edit-prog-fname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-prog-mname" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="edit-prog-mname" name="edit-prog-mname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-prog-lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="edit-prog-lname" name="edit-prog-lname" value="">
                                </div>
                                <div class="col-md-8">
                                    <label for="edit-prog-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit-prog-email" name="edit-prog-email" value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit-prog-role" class="form-label">Role</label>
                                    <select id="edit-prog-role" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option value="lecturer">LECTURER</option>
                                        <option value="hod">HOD</option>
                                        <option value="secretary">SECRETARY</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label for="gender" class="form-label">Gender</label>
                                        <div class="form-check">
                                            <input type="radio" name="edit-prog-gender" id="maleGender" class="form-check-input" value="M">
                                            <label for="maleGender" class="form-check-label">M</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="edit-prog-gender" id="femaleGender" class="form-check-input" value="F">
                                            <label for="femaleGender" class="form-check-label">F</label>
                                        </div>
                                    </div>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="edit-progturer">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->
        <?php
        // endforeach;
        // endif;
        ?>

    </main><!-- End #main -->

    <?php require Base::build_path("partials/foot.php") ?>
    <script>
        $(document).ready(function() {

            $(".editProgramData").on("click", function() {
                lecID = this.dataset.lecturer;

                $.ajax({
                    type: "GET",
                    url: "../api/program/fetch?staff=" + lecID,
                }).done(function(data) {
                    console.log(data);
                    if (data.success) {
                        $("#edit-prog-fname").val(data.message["first_name"]);
                        $("#edit-prog-mname").val(data.message["middle_name"]);
                        $("#edit-prog-lname").val(data.message["last_name"]);
                        $("#edit-prog-email").val(data.message["email"]);
                    } else {
                        alert(data.message)
                    }
                }).fail(function(err) {
                    console.log(err);
                });
            });

            $("#addNewProgBtn").on("click", function() {
                $("#addNewProgForm").submit();
            });

            $("#addNewProgForm").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    type: "GET",
                    url: "../api/program/add",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    cache: false,
                }).done(function(data) {
                    console.log(data);
                    if (data.success) {
                        $("#edit-prog-fname").val(data.message["first_name"]);
                        $("#edit-prog-mname").val(data.message["middle_name"]);
                        $("#edit-prog-lname").val(data.message["last_name"]);
                        $("#edit-prog-email").val(data.message["email"]);
                    } else {
                        alert(data.message)
                    }
                }).fail(function(err) {
                    console.log(err);
                });
            })
        });
    </script>

</body>

</html>