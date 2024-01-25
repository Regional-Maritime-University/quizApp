<?php
session_start();

require("../bootstrap.php");

use Core\Base;
use Controller\Lecturers;

$config = require Base::build_path("config/database.php");

$pageTitle = "Lecturers";
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
                                                <th scope="col">Gender</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $lecturers = new Lecturers($config["database"]["mysql"]);
                                            $all_lecturers = $lecturers->fetchByDepartment($_SESSION["user"]["fk_department"]);

                                            $counter = 1;
                                            foreach ($all_lecturers as $lecturer) :
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $counter ?></th>
                                                    <td><?= trim($lecturer["prefix"] . " " . $lecturer["first_name"] . " " . $lecturer["middle_name"] . " " . $lecturer["last_name"]) ?></td>
                                                    <td><?= $lecturer["role"] ?></td>
                                                    <td><?= $lecturer["gender"] ?></td>
                                                    <td style="display: flex;">
                                                        <a type="button" class="btn btn-info btn-sm me-2" href="?number=<?= $lecturer["number"] ?>" data-lecturer="<?= $lecturer["number"] ?>">View</a>
                                                        <button type="button" class="btn btn-primary btn-sm me-2 editLecturerData" data-lecturer="<?= $lecturer["number"] ?>" data-bs-toggle="modal" data-bs-target="#editLecturer">Edit</button>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="staff" value="<?= $lecturer["number"] ?>">
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

        <?php
        if (isset($_GET["number"]) && !empty($_GET["number"])) :

            $lecturers = new Lecturers($config["database"]["mysql"]);
            $all_lecturers = $lecturers->fetchByDepartment($_SESSION["user"]["fk_department"]);

            $counter = 1;
            foreach ($all_lecturers as $lecturer) :

        ?>
                <!-- Edit Lectuer modal -->
                <div class="modal fade" id="editLecturer" tabindex="-1">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Lecturer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">

                                <div style="display: flex; width:600px">
                                    <!-- Multi Columns Form -->
                                    <form class="row g-3">
                                        <div class="col-md-4">
                                            <label for="edit-lec-prefix" class="form-label">Prefix</label>
                                            <select id="edit-lec-prefix" class="form-select">
                                                <option hidden>Choose...</option>
                                                <option value="Mr" <?= $lecturer["prefix"] === "Mr" ? "selected" : "" ?>>Mr</option>
                                                <option value="Mrs" <?= $lecturer["prefix"] === "Mrs" ? "selected" : ""  ?>>Mrs</option>
                                                <option value="Miss" <?= $lecturer["prefix"] === "Miss" ? "selected" : ""  ?>>Miss</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label for="edit-lec-fname" class="form-label">First Name</label>
                                            <input type="email" class="form-control" id="edit-lec-fname" name="edit-lec-fname" value="<?= $lecturer['first_name'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit-lec-mname" class="form-label">Middle Name</label>
                                            <input type="password" class="form-control" id="edit-lec-mname" name="edit-lec-mname" value="<?= $lecturer['middle_name'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit-lec-lname" class="form-label">Last Name</label>
                                            <input type="email" class="form-control" id="edit-lec-lname" name="edit-lec-lname" value="<?= $lecturer['last_name'] ?>">
                                        </div>
                                        <div class="col-md-8">
                                            <label for="edit-lec-email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="edit-lec-email" name="edit-lec-email" value="<?= $lecturer['email'] ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="edit-lec-role" class="form-label">Role</label>
                                            <select id="edit-lec-role" class="form-select">
                                                <option hidden>Choose...</option>
                                                <option value="lecturer" <?= $lecturer["role"] === "lecturer" ? "selected" : "" ?>>LECTURER</option>
                                                <option value="hod" <?= $lecturer["role"] === "hod" ? "selected" : ""  ?>>HOD</option>
                                                <option value="secretary" <?= $lecturer["role"] === "secretary" ? "selected" : ""  ?>>SECRETARY</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <label for="gender" class="form-label">Gender</label>
                                                <div class="form-check">
                                                    <input type="radio" name="edit-lec-gender" id="maleGender" class="form-check-input" value="M" <?= $lecturer['gender'] === 'M' ? 'checked' : '' ?>>
                                                    <label for="maleGender" class="form-check-label">M</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="edit-lec-gender" id="femaleGender" class="form-check-input" value="F" <?= $lecturer['gender'] === 'F' ? 'checked' : '' ?>>
                                                    <label for="femaleGender" class="form-check-label">F</label>
                                                </div>
                                            </div>
                                        </div>
                                    </form><!-- End Multi Columns Form -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                                <label class="btn btn-primary" for="edit-lecturer">Save changes</label>
                            </div>
                        </div>
                    </div>
                </div><!-- End Full Screen Modal-->
        <?php
            endforeach;
        endif;
        ?>

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