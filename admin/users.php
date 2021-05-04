<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect(login.php);} ?>
<?php 
$users = User::find_all();
?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button
      type="button"
      class="navbar-toggle"
      data-toggle="collapse"
      data-target=".navbar-ex1-collapse"
    >
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.html">SB Admin</a>
  </div>

  <!-- Top Menu Items -->
  <?php include("includes/top_nav.php")?>

  <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
  <?php include("includes/side_nav.php")?>

  <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">
         user
          <small>Subheading</small>
        </h1>
        <div class="col-md-12">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
              </tr>
            </thead>
            <tbody>  
              <?php foreach ($users as $user) : ?>
                <tr>
                <td><?php echo $user->id; ?></td>
                <td><img src="<?php echo $user->image_path_and_placeholder(); ?>" width="62" height="62" alt=""></td> 
            
                <td><?php echo $user->username; ?>
                  <div class="action-links">
                    <a href="delete-user.php?id=<?php echo $user->id; ?>" >Delete</a>
                    <a href="edit-user.php?id=<?php echo $user->id; ?>" >Edit</a>
                    <a href="" >View</a>
                  </div>
                </td>
                <td><?php echo $user->firstname; ?></td>
                <td><?php echo $user->lastname; ?></td>
              </tr>
            <?php endforeach ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
