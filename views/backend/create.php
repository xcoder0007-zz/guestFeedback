<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('views/backend/back_head.php') ?>
</head>
  
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create <?php echo $this->data['title']; ?></h3>
                    </div>

                    <form class="form-horizontal" action="create.php" method="post">
                    
                    <?php foreach ($this->data['inputs'] as $key => $input): ?>

                      <?php if ($input['type'] == "hidden"): ?>
                        <input name="<?php echo $input['field'] ?>" type="hidden" value="<?php echo (isset($this->data['user']))? $this->data['user'][$input['field']] : '';?>">
                      
                      <?php elseif ($input['type'] == "multiple"): ?>
                          
                      <?php else: ?>
                        <label class="control-label"><?php echo $input['head'] ?></label>
                        <div class="controls">
                            <input name="<?php echo $input['field'] ?>" type="text"  placeholder="<?php echo $input['head'] ?>" value="<?php echo (isset($this->data['user']))? $this->data['user'][$input['field']] : '';?>">
                        </div>
                      <?php endif ?>

                    <?php endforeach ?>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="/backend/<?php echo $this->data['table']; ?>">Back</a>
                      </div>

                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>