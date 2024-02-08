<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="./index.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <?php if (isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "lecturer") { ?>
            <li class="nav-item">
                <a class="nav-link  <?= $pageTitle === "Quizzes" ? "" : "collapsed" ?>" href="./quizzes.php">
                    <i class="bi bi-person"></i>
                    <span>Quiz</span>
                </a>
            </li>   <li class="nav-item">
                <a class="nav-link  <?= $pageTitle === "Questions" ? "" : "collapsed" ?>" href="./questions.php">
                    <i class="bi bi-person"></i>
                    <span>Questions</span>
                </a>
            </li>   <li class="nav-item">
                <a class="nav-link  <?= $pageTitle === "Assesment" ? "" : "collapsed" ?>" href="./assesment.php">
                    <i class="bi bi-person"></i>
                    <span>Assesment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  <?= $pageTitle === "Classes" ? "" : "collapsed" ?>" href="./classes.php">
                    <i class="bi bi-person"></i>
                    <span>Classes</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link  <?= $pageTitle === "Courses" ? "" : "collapsed" ?>" href="./courses.php">
                    <i class="bi bi-person"></i>
                    <span>Courses</span>
                </a>
            </li><!-- End Profile Page Nav -->

        <?php } ?>

    </ul>

</aside><!-- End Sidebar-->

</ul>

</aside><!-- End Sidebar-->
