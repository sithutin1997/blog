<?php
session_start();
require 'config/config.php';
require 'config/common.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in']))
{
  header('Location: login.php');
};
if ($_SESSION['role'] == 1) {
  header('Location: login.php');
}

$stmt=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();

$post_id = $_GET['id'];

$stmt1=$pdo->prepare("SELECT * FROM comments WHERE post_id=$post_id");
$stmt1->execute();
$cmResult=$stmt1->fetchAll();

$auResult = [];

if ($cmResult) {
  foreach ($cmResult as $key => $value) {
    $auId = $cmResult[$key]['author_id'];
    $stmt2=$pdo->prepare("SELECT * FROM users WHERE id=$auId");
    $stmt2->execute();
    $auResult[]=$stmt2->fetchAll();

}
}
if($_POST)
{
  if (empty($_POST['comment']))
  {
      $cmtError = 'Comment needs to be filled';
  }else{
      $content = $_POST['comment'];

      $stmt = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES(:content,:author_id,:post_id)");
      $result = $stmt->execute(
        array(
          ':content' => $content,
          ':author_id' => $_SESSION['user_id'],
          ':post_id' => $post_id
        )
      );
      if ($result) {
        header('Location: blogdetail.php?id='.$post_id);
      }
    }
}

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px !important;">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="card card-widget">
            <div class="card-header">
              <div class="card-header">
                <div  style="text-align:center !important;float:none;" class="card-title">
                  <h4><?php echo escape($result[0]['title']) ?></h4>

                </div>
                <!-- /.user-block -->

                <!-- /.card-tools -->
              </div>
              <!-- /.user-block -->

              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image'] ?>">
              <br><br>
              <p><?php echo escape($result[0]['content']) ?></p>
              <h3>Comments</h3><hr>
              <a href="index.php" type="button" class="btn btn-default">Back</a>
            </div>
            <!-- /.card-body -->
            <div class="card-footer card-comments">
              <div class="card-comment">
            <?php
                  if($cmResult)
                  { ?>
                    <div class="comment-text" style="margin-left:0px !important;">
                  <?php  foreach ($cmResult as $key => $value) {
                ?>
                      <span class="username">
                      <?php echo escape($auResult[$key][0]['name']) ?>
                        <span class="text-muted float-right"><?php echo escape($value['created_at']);  ?></span>
                      </span><!-- /.username -->
                        <?php echo escape($value['content']) ?>
                        <?php
                      } ?>
                        </div>
                        <!-- /.comment-text -->
                      </div>
                      <!-- /.card-comment -->

                      <!-- /.card-comment -->
                    </div>
                      <?php

                }

             ?>

            <!-- /.card-footer -->
            <div class="card-footer">
              <form action="" method="post">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                <p style="color:red;"><?php echo empty($cmtError) ? '' : '*'.$cmtError; ?></p>

                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                </div>
              </form>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
      </div>
      </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer" style="margin-left: 0px !important;">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
    <a href="logout.php" type="button" class="btn btn-default">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="#">Si Thu Tin</a>.</strong> All rights reserved.
  </footer>
  </div>
  <!-- ./wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
