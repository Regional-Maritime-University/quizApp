<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="index.html">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <?php if (isset($_SESSION["user"]["role"]) && ($_SESSION["user"]["role"] === "secretary" || $_SESSION["user"]["role"] === "hod")) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#assign-nav" data-bs-toggle="collapse" href="javascript:void(0);">
                    <i class="bi bi-menu-button-wide"></i><span>Assign</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="assign-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="assign/courses.php">
                            <i class="bi bi-circle"></i><span>Course</span>
                        </a>
                    </li>
                    <li>
                        <a href="assign/classes.php">
                            <i class="bi bi-circle"></i><span>Class</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="lecturers.php">
                    <i class="bi bi-people"></i>
                    <span>Lecturers</span>
                </a>
            </li><!-- End Lecturers Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="programs.php">
                    <i class="bi bi-bookshelf"></i>
                    <span>Programs</span>
                </a>
            </li><!-- End Programmes Page Nav -->

        <?php } ?>

        <li class="nav-item">
            <a class="nav-link collapsed" href="students.php">
                <i class="bi bi-people"></i>
                <span>Students</span>
            </a>
        </li><!-- End Students Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="classes.php">
                <i class="bi bi-dash-circle"></i>
                <span>Classes</span>
            </a>
        </li><!-- End Classes Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="courses.php">
                <i class="bi bi-collection"></i>
                <span>Courses</span>
            </a>
        </li><!-- End Courses Page Nav -->

        <?php if (isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "lecturer") { ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="quizzes.php">
                    <i class="bi bi-person"></i>
                    <span>Quiz</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="questions.php">
                    <i class="bi bi-person"></i>
                    <span>Questions</span>
                </a>
            </li><!-- End Profile Page Nav -->

        <?php } ?>

    </ul>

</aside><!-- End Sidebar-->