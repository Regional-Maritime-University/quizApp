<?php
session_start();

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    // Redirect to index.php
    header("Location: ./index.php");
    exit(); // Make sure to exit after redirection
}

require("../bootstrap.php");

use Controller\Counts;
use Core\Base;

$config = require Base::build_path("config/database.php");
$counts = new Counts($config["database"]["mysql"]);

$pageTitle = "Dashboard";
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
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card sales-card">



                                <div class="card-body">
                                    <h5 class="card-title">Students</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-contacts-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $counts->totalStudents($_SESSION["user"]["fk_department"]) ?></h6>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card revenue-card">



                                <div class="card-body">
                                    <h5 class="card-title">Staff</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-account-pin-box-line"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $counts->totalLecturers($_SESSION["user"]["fk_department"]) ?></h6>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-3 col-md-6">

                            <div class="card info-card customers-card">



                                <div class="card-body">
                                    <h5 class="card-title">Courses</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-booklet-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $counts->totalCourses($_SESSION["user"]["fk_department"]) ?></h6>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-3 col-md-6">

                            <div class="card info-card customers-card">



                                <div class="card-body">
                                    <h5 class="card-title">Programs</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-book-read-line"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $counts->totalPrograms($_SESSION["user"]["fk_department"]) ?></h6>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Reports Card -->

                    </div>
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card report-card">



                                <div class="card-body">
                                    <h5 class="card-title">Classes</h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $counts->totalClasses($_SESSION["user"]["fk_department"]) ?></h6>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End Sales Card -->
                        <?PHP

                        // var_dump("$_SESSION");
                        ?>

                    </div><!-- End Left side columns -->

                </div>
        </section>

    </main><!-- End #main -->

    <?php require Base::build_path("partials/foot.php") ?>

</body>

</html>