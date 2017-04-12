<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('views/backend/back_head.php') ?>
</head>
  
<body>
    <div class="container">
     
      <div class="span10 offset1">
        <div class="row">
          <h3> Login</h3>
        </div>

        <div class="row">
        <?php if (isset($this->data['error'])): ?>
          <p class="alert-danger"><?php echo $this->data['error'] ?></p>
        <?php endif ?>
        </div>

        <form class="form-horizontal" action="" method="post" enctype='multipart/form-data'>

          <label class="control-label">Username</label>
          <div class="controls">
              <input name="user" placeholder="Username" type="text" >
          </div>

          <label class="control-label">Password</label>
          <div class="controls">
              <input name="pass" type="password" >
          </div>

          <div class="form-actions">
              <button type="submit" class="btn btn-success">Let me in</button>
          </div>

        </form>
      </div>
                 
    </div> <!-- /container -->
  </body>
</html>