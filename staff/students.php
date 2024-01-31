<?php
session_start();

require("../bootstrap.php");

use Core\Base;
use Controller\Students;

$config = require Base::build_path("config/database.php");

$pageTitle = "Students";
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
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addNewStudent">Add</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Bordered Table</h5>
                                    <!-- Bordered Table -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Index Number</th>
                                                <th scope="col">Class</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $students = new Students($config["database"]["mysql"]);
                                            $all_students = $students->fetchByDepartment($_SESSION["user"]["fk_department"]);

                                            $counter = 1;
                                            foreach ($all_students as $student) :
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $counter ?></th>
                                                    <td><?= trim($student["firstName"] . " " . $student["middleName"] . " " . $student["lastName"]) ?></td>
                                                    <td><?= $student["indexNumber"] ?></td>
                                                    <td><?= $student["fk_class"] ?></td>

                                                    <td style="display: flex;">
                                                        <button type="button" class="btn btn-primary btn-sm me-2 editstudentData" data-student="<?= $student["indexNumber"] ?>" data-bs-toggle="modal" data-bs-target="#editstudent">Edit</button>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="student" value="<?= $student["indexNumber"] ?>">
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
        <div class="modal fade" id="addNewStudent" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add new student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">
                        <div style="display: flex; width:600px">
                            <!-- Multi Columns Form -->
                            <form id="addNewLecForm" class="row g-3" method="POST">
                                <div class="col-md-4">
                                    <label for="add-stud-prefix" class="form-label">Prefix</label>
                                    <select name="add-stud-prefix" id="add-stud-prefix" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="add-stud-fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="add-stud-fname" name="add-stud-fname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="add-stud-mname" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="add-stud-mname" name="add-stud-mname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="add-stud-lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="add-stud-lname" name="add-stud-lname" value="">
                                </div>
                                <div class="col-md-8">
                                    <label for="add-stud-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="add-stud-email" name="add-stud-email" value="">
                                </div>

                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <div class="form-check">
                                        <input type="radio" name="add-stud-gender" id="maleGender" class="form-check-input" value="M">
                                        <label for="maleGender" class="form-check-label">M</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="add-stud-gender" id="femaleGender" class="form-check-input" value="F">
                                        <label for="femaleGender" class="form-check-label">F</label>
                                    </div>
                                </div>
                                <input type="hidden" name="add-stud-depart" value="<?= $_SESSION["user"]["fk_department"] ?>">
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="add-student" id="addNewstudBtn">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->

        <?php
        // if (isset($_GET["indexNumber"]) && !empty($_GET["number"])) :

        //     $Students = new Students($config["database"]["mysql"]);
        //     $all_studturers = $lecturers->fetchByDepartment($_SESSION["user"]["fk_department"]);

        //     $counter = 1;
        //     foreach ($all_lecturers as $lecturer) :

        ?>
        <!-- Edit Lectuer modal -->
        <div class="modal fade" id="editstudent" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">

                        <div style="display: flex; width: 600px; align-items: center;">
                            <!-- Multi Columns Form -->
                            <form class="row g-3">
                                <div class="col-md-4">
                                    <label for="edit-stud-prefix" class="form-label">Prefix</label>
                                    <select id="edit-stud-prefix" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="edit-stud-fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="edit-stud-fname" name="edit-stud-fname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-stud-mname" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="edit-stud-mname" name="edit-stud-mname" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="edit-stud-lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="edit-stud-lname" name="edit-stud-lname" value="">
                                </div>
                                <div class="col-md-8">
                                    <label for="edit-stud-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit-stud-email" name="edit-stud-email" value="">
                                </div>

                                <div class="col-md-4">
                                    <div class="row">
                                        <label for="gender" class="form-label">Gender</label>
                                        <div class="form-check">
                                            <input type="radio" name="edit-stud-gender" id="maleGender" class="form-check-input" value="M">
                                            <label for="maleGender" class="form-check-label">M</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="edit-stud-gender" id="femaleGender" class="form-check-input" value="F">
                                            <label for="femaleGender" class="form-check-label">F</label>
                                        </div>
                                    </div>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="edit-student">Save changes</label>
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

            $(".editstudentData").on("click", function() {
                lecID = this.dataset.student;

                $.ajax({
                    type: "GET",
                    url: "../api/student/fetch?student=" + lecID,
                }).done(function(data) {
                    console.log(data);
                    if (data.success) {
                        $("#edit-stud-fname").val(data.message["first_name"]);
                        $("#edit-stud-mname").val(data.message["middle_name"]);
                        $("#edit-stud-lname").val(data.message["last_name"]);
                        $("#edit-stud-email").val(data.message["email"]);
                    } else {
                        alert(data.message)
                    }
                }).fail(function(err) {
                    console.log(err);
                });
            });

            $("#addNewLecBtn").on("click", function() {
                $("#addNewLecForm").submit();
            });

            $("#addNewLecForm").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    type: "GET",
                    url: "../api/student/add",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    cache: false,
                }).done(function(data) {
                    console.log(data);
                    if (data.success) {
                        $("#edit-stud-fname").val(data.message["first_name"]);
                        $("#edit-stud-mname").val(data.message["middle_name"]);
                        $("#edit-stud-lname").val(data.message["last_name"]);
                        $("#edit-stud-email").val(data.message["email"]);
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