<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']))
{
  header('Location: login.php');
};
if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

if($_POST)
{
  if (!empty($_POST['role'])) {
    $role = 1;
  }else {
    $role = 2;
  }


    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt2 = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt2->bindValue(':email',$email);
    $stmt2->execute();
    $user=$stmt2->fetch(PDO::FETCH_ASSOC);
    if ($user) {
      echo"<script>alert('Email duplicated');</script>";
    }else {
      $stmt = $pdo->prepare("INSERT INTO users(name,password,email,role) VALUES(:name,:password,:email,:role)");
      $result = $stmt->execute(
        array(
          ':name' => $name,
          ':password' => $password,
          ':email' => $email,
          ':role' => $role
        )
      );
      if ($result) {
        echo"<script>alert('New User is added');window.location.href='user_list.php';</script>";

      }
    }

}
?>

<?php include('header.php'); ?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="user_add.php" method="post">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control"name="name" value="" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleInputEmail1">Email address</label>
                     <input type="email" class="form-control" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="role">
                    <label class="form-check-label" for="exampleCheck1">Admin?</label>
                  </div><br><br>
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
