<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']))
{
  header('Location: login.php');
};

if($_POST)
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='0' WHERE id='$id'");
    $result = $stmt->execute();
    if ($result) {
      echo"<script>alert('User is Successfully Updated');window.location.href='user_list.php';</script>";
    }
}
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();
?>

<?php include('header.php'); ?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name'] ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="content">Email</label><br>
                    <input class="form-control" name="email" rows="8" cols="80" value="<?php print_r($result[0]['email']) ?>"required >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password"value="<?php echo $result[0]['password'] ?>" required>
                  </div>
                  <div class="form-group">
                  <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                  <a href="user_list.php" type="button" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>
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