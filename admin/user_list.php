<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']))
{
  header('Location: login.php');
};
?>

<?php include('header.php'); ?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Listing</h3>
              </div>
              <?php
              if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
              } else {
                $pageno = 1;
              }
              $numOfrecs = 1;
              $offset = ($pageno - 1) * $numOfrecs;

                if(empty($_POST['search']))
                {
                  $stmt=$pdo->prepare("SELECT * FROM users ORDER BY id");
                  $stmt->execute();
                  $rawResult=$stmt->fetchAll();
                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt=$pdo->prepare("SELECT * FROM users ORDER BY id LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $result=$stmt->fetchAll();
                } else {
                  $searchKey = $_POST['search'];
                  $stmt=$pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id");
                  $stmt->execute();
                  $rawResult=$stmt->fetchAll();
                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt=$pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $result=$stmt->fetchAll();
                }
               ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="">
                    <a href="user_add.php" type="button" class="btn btn-success">Add New User</a>

                </div>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Gmail</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                      <?php
                      if($result)
                      {
                        $i = 1;
                        foreach ($result as $value) {
                          ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $value['email']; ?></td>
                            <td>
                              <div class="btn btn-group">
                                <div class="Container">
                                    <a href="user_edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a>
                                </div>
                                <div class="container">
                                    <a href="user_delete.php?id=<?php echo $value['id'] ?>"
                                      onclick="return confirm('Do you want to delete this post?')"
                                      type="button" class="btn btn-danger">Delete</a>
                                </div>
                              </div>

                            </td>
                          </tr>
                      <?php
                          $i++; }
                      }
                       ?>

                  </tbody>
                </table>
                <nav aria-label="Page navigation example"><br>
                      <ul class="pagination" style="float:right">
                        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                        <li class="page-item <?php if($pageno <= 1) {echo 'disabled';} ?>">
                          <a class="page-link" href="<?php if($pageno <= 1) {echo "#";}else {echo "?pageno=".($pageno-1);} ?>">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                        <li class="page-item <?php if($pageno >= $total_pages) {echo 'disabled';} ?>">
                          <a class="page-link" href="<?php if($pageno >= $total_pages) {echo "#";}else {echo "?pageno=".($pageno+1);} ?>">Next</a></li>
                        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages ?>">Last</a></li>
                      </ul>
                </nav>
              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html'); ?>
