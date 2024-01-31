<?php
session_start();

require("../bootstrap.php");

use Controller\Classes;
use Core\Base;

$config = require Base::build_path("config/database.php");

$pageTitle = "Classes";
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
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addNewclass">Add</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Classes</h5>
                                    <!-- Bordered Table -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Program</th>
                                                <th scope="col">Program Name</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $classes = new Classes($config["database"]["mysql"]);
                                            $all_classes = $classes->fetchByDepartment($_SESSION["user"]["fk_department"]);
                                            $rowCounter = 1;
                                            foreach ($all_classes as $classes) {
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $rowCounter ?></th>
                                                    <td><?= $classes["classCode"] ?></td>
                                                    <td><?= $classes["programCode"] ?></td>
                                                    <td><?= $classes["programName"] ?></td>
                                                    <td style="display: flex;">
                                                        <button type="button" class="btn btn-primary btn-sm me-2 editclassesData" data-classes="<?= $classes["classCode"] ?>" data-bs-toggle="modal" data-bs-target="#editclasses">Edit</button>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="classes" value="<?= $classes["classCode"] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm">Archive</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                                $rowCounter++;
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
        <div class="modal fade" id="addNewclass" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">

                        <div style="display: flex; width: 600px; align-items: center;">
                            <!-- Multi Columns Form -->
                            <form class="row g-3">


                                <div class="col-md-8">
                                    <label for="class_code" class="form-label">Class Code</label>
                                    <input type="text" class="form-control" id="class_code">
                                </div>
                                <div class="col-md-4">
                                    <label for="class_program" class="form-label">Program</label>
                                    <select id="class_program" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option>BIT</option>
                                        <option>BCS</option>
                                        <!-- <option>Miss</option> -->
                                    </select>
                                </div>

                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="add-classes">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->

        <!-- Edit Lectuer modal -->
        <div class="modal fade" id="editclasses" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">

                        <div style="display: flex; width: 600px; align-items: center;">
                            <!-- Multi Columns Form -->
                            <form class="row g-3">


                                <div class="col-md-8">
                                    <label for="class_code" class="form-label">Class Code</label>
                                    <input type="text" class="form-control" id="class_code">
                                </div>
                                <div class="col-md-4">
                                    <label for="class_program" class="form-label">Program</label>
                                    <select id="class_program" class="form-select">
                                        <option hidden>Choose...</option>
                                        <option>BIT</option>
                                        <option>BCS</option>
                                        <!-- <option>Miss</option> -->
                                    </select>
                                </div>

                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="edit-class">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->

    </main><!-- End #main -->

    <?php require Base::build_path("partials/foot.php") ?> <script>
        $(document).ready(function() {

            $(".editclassesData").on("click", function() {
                classID = this.dataset.classes;

                $.ajax({
                    type: "GET",
                    url: "../api/class/fetch?class=" + classID,
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