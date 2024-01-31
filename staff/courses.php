<?php
session_start();

require("../bootstrap.php");

use Core\Base;
use Controller\Courses;

$config = require Base::build_path("config/database.php");

$pageTitle = "Courses";
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
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addNewcourse">Add</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Courses</h5>
                                    <!-- Bordered Table -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Course Code</th>
                                                <th scope="col">Course Name</th>
                                                <th scope="col">Credit Hours</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $courses = new Courses($config["database"]["mysql"]);
                                            $all_courses = $courses->fetchByDepartment($_SESSION["user"]["fk_department"]);
                                            $rowCounter = 1;
                                            foreach ($all_courses as $course) {
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $rowCounter++ ?></th>
                                                    <td><?= $course["courseCode"] ?></td>
                                                    <td><?= $course["courseName"] ?></td>
                                                    <td><?= $course["creditHours"] ?></td>
                                                    <td style="display: flex;">
                                                        <button type="button" class="btn btn-primary btn-sm me-2 editcourseData" data-course="<?= $course["courseCode"] ?>" data-bs-toggle="modal" data-bs-target="#editcourse">Edit</button>
                                                        <form class="archive-form">
                                                            <input type="hidden" name="code" value="<?= $course["courseCode"] ?>">
                                                            <button type="button" class="btn btn-danger btn-sm archive-button">Archive</button>
                                                        </form>
                                                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $(".archive-button").on("click", function() {
                                                                    // Get the course code from the data attribute
                                                                    var courseCode = $(this).closest(".archive-form").data("course-code");

                                                                    // AJAX request to call the archive function
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "api/course/", // Replace with the actual path
                                                                        data: {
                                                                            api: "archiveCourse", // This value corresponds to the API route or function name on the server
                                                                            courses: [{
                                                                                code: courseCode
                                                                            }] // Send an array of courses (in this case, just one course)
                                                                        },
                                                                        success: function(response) {
                                                                            // Handle the response from the server
                                                                            console.log(response);
                                                                            if (response.success) {
                                                                                alert("Archive successful");
                                                                                // Optionally, you can update the UI to reflect the archived state
                                                                                // For example, hide the archived row
                                                                                $(this).closest("tr").hide();
                                                                            } else {
                                                                                alert("Archive failed");
                                                                            }
                                                                        },
                                                                        error: function(error) {
                                                                            console.error(error);
                                                                            alert("Error during the AJAX request");
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>


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
        <!-- Add new course modal -->
        <div class="modal fade" id="addNewcourse" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add new Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">

                        <div style="display: flex; width: 800px; align-items: center;">
                            <!-- Multi Columns Form -->
                            <form class="row g-3">
                                <div class="col-md-8">
                                    <label for="addcourseCode" class="form-label">Course Code</label>
                                    <input type="text" class="form-control" id="addcourseCode">
                                </div>
                                <div class="col-md-8">
                                    <label for="addcourseName" class="form-label">Class Name</label>
                                    <input type="text" class="form-control" id="addcourseName">
                                </div>
                                <div class="col-md-8">
                                    <label for="addcreditHours" class="form-label">Credit Hours</label>
                                    <input type="text" class="form-control" id="addcreditHours">
                                </div>

                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label class="btn btn-secondary" data-bs-dismiss="modal">Close</label>
                        <label class="btn btn-primary" for="add-course">Save changes</label>
                    </div>
                </div>
            </div>
        </div><!-- End Full Screen Modal-->

        <!-- Edit Lectuer modal -->
        <div class="modal fade" id="editcourse" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="display: grid; place-items: center; height: 100vh; margin: 0;">

                        <div style="display: flex; width: 600px; align-items: center;">


                            <!-- Multi Columns Form -->
                            <form class="row g-3">
                                <div class="col-md-8">
                                    <label for="edit-course-code" class="form-label">Course Code</label>
                                    <input type="text" class="form-control" id="edit-course-code" value="<?= $course["courseCode"] ?>">
                                </div>
                                <div class="col-md-8">
                                    <label for="edit-course-name" class="form-label">Course Name</label>
                                    <input type="text" class="form-control" id="edit-course-name" value="<?= $course["courseName"] ?>">
                                </div>
                                <div class="col-md-8">
                                    <label for="edit-credit-hours" class="form-label">Credit Hours</label>
                                    <input type="text" class="form-control" id="edit-credit-hours" value="<?= $course["creditHours"] ?>">
                                </div>
                                <div class="text-center">
                                    <button type="button" id="editButton" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" for="editButton">Save changes</button>
                    </div>
                </div>
            </div><!-- Include jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



            <script>
                // editCourseScript.js

                $(document).ready(function() {
                    // Function to handle the button click
                    $("#editButton").on("click", function() {
                        // Prepare data for the edit function
                        var courseData = {
                            code: $("#edit-course-code").val(),
                            name: $("#edit-course-name").val(),
                            credit_hours: $("#edit-credit-hours").val()
                        };

                        // AJAX request to call the edit function
                        $.ajax({
                            type: "POST",
                            url: "more.php", // Replace with the actual path
                            data: {
                                api: "editCourse", // This value corresponds to the API route or function name on the server
                                courseData: courseData
                            },
                            success: function(response) {
                                // Handle the response from the server
                                console.log(response);
                                if (response.success) {
                                    alert("Edit successful");
                                } else {
                                    alert("Edit failed");
                                }
                            },
                            error: function(error) {
                                console.error(error);
                                alert("Error during the AJAX request");
                            }
                        });
                    });
                });
            </script>
        </div>
        <!-- End Full Screen Modal-->
    </main><!-- End #main -->

    <?php require Base::build_path("partials/foot.php") ?>
    <script>
        // $(document).ready(function() {
        //     $("#fetchData").on("submit", function(e) {
        //         e.preventDefault();

        //         $.ajax({
        //             type: "GET",
        //             url: "api/course/fetch?a=1&b=2",
        //             data: new FormData(this),
        //             contentType: false,
        //             processData: false,
        //         }).done(function(data) {
        //             console.log(data);
        //         }).fail(function(err) {
        //             console.log(err);
        //         });
        //     });
        // });
    </script>

</body>

</html>