<?php
session_start();

require("../bootstrap.php");

use Core\Base;

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
                    <div class="row">

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
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Brandon Jacob</td>
                                                <td>Designer</td>
                                                <td>28</td>
                                                <td style="display: flex;">
                                                    <button type="button" class="btn btn-primary btn-sm me-2">Edit</button>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="staff" value="">
                                                        <button type="submit" class="btn btn-danger btn-sm">Archive</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- End Bordered Table -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Left side columns -->

            </div>
        </section>

    </main><!-- End #main -->

    <?php require Base::build_path("partials/foot.php") ?>
    <script>
        $(document).ready(function() {
            $("#fetchData").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    type: "GET",
                    url: "api/course/fetch?a=1&b=2",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                }).done(function(data) {
                    console.log(data);
                }).fail(function(err) {
                    console.log(err);
                });
            });
        });
    </script>

</body>

</html>