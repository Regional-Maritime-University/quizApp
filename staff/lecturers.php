<?php
session_start();

require("../bootstrap.php");

use Core\Base;
use Controller\Lecturers;

$pageTitle = "try";
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
                                    <h5 class="card-title">Bordered Table</h5>
                                    <!-- Bordered Table -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Sex</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $config = require Base::build_path("config/database.php");
                                            $lecturers = new Lecturers($config["database"]["mysql"]);
                                            $all_lecturers = $lecturers->fetchByDepartment($_SESSION["user"]["fk_department"]);

                                            foreach ($all_lecturers as $lecturer) {
                                            ?>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td><?= trim($lecturer["prefix"] . " " . $lecturer["first_name"] . " " . $lecturer["middle_name"] . " " . $lecturer["last_name"]) ?></td>
                                                    <td><?= $lecturer["role"] ?></td>
                                                    <td><?= $lecturer["gender"] ?></td>
                                                    <td style="display: flex;">
                                                        <button type="button" class="btn btn-primary btn-sm me-2 editLecturerData" data-lecturer="<?= $lecturer["number"] ?>" data-bs-toggle="modal" data-bs-target="#editLecturer">Edit</button>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="staff" value="<?= $lecturer["number"] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm">Archive</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
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
        <div class="modal fade" id="addNewLecturer" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add new lecturer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div style="display: flex; width:800px">
                            <!-- Multi Columns Form -->
                            <form class="row g-3">
                                <div class="col-md-2">
                                    <label for="inputState" class="form-label">Prefix</label>
                                    <select id="inputState" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option>Mr</option>
                                        <option>Mrs</option>
                                        <option>Miss</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="inputEmail5" class="form-label">First Name</label>
                                    <input type="email" class="form-control" id="inputEmail5">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputPassword5" class="form-label">Middle Name</label>
                                    <input type="password" class="form-control" id="inputPassword5">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputEmail5" class="form-label">Last Name</label>
                                    <input type="email" class="form-control" id="inputEmail5">
                                </div>
                                <div class="col-md-8">
                                    <label for="inputPassword5" class="form-label">Email</label>
                                    <input type="password" class="form-control" id="inputPassword5">
                                </div>
                                <div class="col-md-4">
                                    <label for="inputAddress5" class="form-label">Role</label>
                                    <select id="inputState" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option>Mr</option>
                                        <option>Mrs</option>
                                        <option>Miss</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <input type="radio" name="gender" id="gender" value="M"> M
                                    <input type="radio" name="gender" id="gender" value="F"> F
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="add-lecturer" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="add-lecturer">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->

        <!-- Edit Lectuer modal -->
        <div class="modal fade" id="editLecturer" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Lecturer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div style="display: flex; width:800px">
                            <!-- Multi Columns Form -->
                            <form class="row g-3">
                                <div class="col-md-2">
                                    <label for="add-lec-prefix" class="form-label">Prefix</label>
                                    <select id="add-lec-prefix" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option>Mr</option>
                                        <option>Mrs</option>
                                        <option>Miss</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="add-lec-fname" class="form-label">First Name</label>
                                    <input type="email" class="form-control" id="add-lec-fname" name="add-lec-fname">
                                </div>
                                <div class="col-md-3">
                                    <label for="add-lec-mname" class="form-label">Middle Name</label>
                                    <input type="password" class="form-control" id="add-lec-mname" name="add-lec-mname">
                                </div>
                                <div class="col-md-3">
                                    <label for="add-lec-lname" class="form-label">Last Name</label>
                                    <input type="email" class="form-control" id="add-lec-lname" name="add-lec-lname">
                                </div>
                                <div class="col-md-8">
                                    <label for="add-lec-email" class="form-label">Email</label>
                                    <input type="password" class="form-control" id="add-lec-email" name="add-lec-email">
                                </div>
                                <div class="col-md-4">
                                    <label for="add-lec-role" class="form-label">Role</label>
                                    <select id="add-lec-role" class="form-select">
                                        <option hidden>Choose...</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <input type="radio" name="gender" id="gender" value="M"> M
                                    <input type="radio" name="gender" id="gender" value="F"> F
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="add-lecturer" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="add-lecturer">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->

    </main><!-- End #main -->

    <?php require Base::build_path("partials/foot.php") ?>
    <script>
        $(document).ready(function() {

            $(".editLecturerData").on("click", function() {
                lecID = this.dataset.lecturer;

                $.ajax({
                    type: "GET",
                    url: "../api/lecturer/fetch?staff=" + lecID,
                }).done(function(data) {
                    console.log(data);
                }).fail(function(err) {
                    console.log(err);
                });
            })
        });
    </script>

</body>

</html>