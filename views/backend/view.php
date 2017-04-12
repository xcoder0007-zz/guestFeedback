<!DOCTYPE html>
<html lang="en">
  <head>
      <?php include('views/backend/back_head.php') ?>
  </head>
   
  <body>
    <?php include('views/backend/back_menu.php') ?>
    <div class="container">
      <?php if (isset($this->data['table'])): ?>
        
      
            <div class="row">
                <h3><?php echo $this->data['title']; ?></h3>
            </div>
            <div class="row">
                <p>
                  <a href="/backend/<?php echo $this->data['action'] ?>" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                    <?php foreach ($this->data['heads'] as $head): ?>
                      <th><?php echo $head; ?></th>
                    <?php endforeach ?>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($this->data[$this->data['table']] as $row): ?>
                    <tr>
                    <?php foreach ($this->data['fields'] as $cell): ?>
                      <td><?php echo $row[$cell] ?></td>
                    <?php endforeach ?>
                      <td>
                        <a class="btn btn-success" href="/backend/<?php echo $this->data['action'] ?>/<?php echo $row['id'] ?>">Update</a>
                        <a class="btn btn-danger delete" data-placement="right" data-href="/backend/<?php echo $this->data['action'] ?>_rem/<?php echo $row['id'] ?>">Delete</a>
                      </td>
                    </tr>
                  <?php endforeach ?>
                  </tbody>
            </table>
        </div>
        <?php endif ?>
    </div> <!-- /container -->
  </body>
</html>