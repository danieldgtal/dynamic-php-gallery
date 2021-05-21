<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.php">SB Admin</a>
            </div>

            <!-- Top Menu Items -->
            <?php include("includes/top_nav.php")?>



            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/side_nav.php")?>


            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

           <?php include("includes/admin_content.php");?>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>