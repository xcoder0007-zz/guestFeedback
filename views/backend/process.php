<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('views/backend/back_head.php') ?>
</head>
  
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                      <h3> <?php echo ($this->data[$this->data['item']]['id'])? $this->data['title']." #".$this->data[$this->data['item']]['id'] : "New ".$this->data['title']; ?></h3>
                    </div>

                    <div class="row">
                    <?php if (isset($this->data['error'])): ?>
                      <p class="alert-danger"><?php 
                      if (is_array($this->data['error'])) {
                         foreach ($this->data['error'] as $error) {
                           echo $error."<br />";
                         }
                      }else {
                        echo $this->data['error'];
                      } ?></p>
                    <?php endif ?>
                    </div>

                    <form class="form-horizontal" action="" method="post" enctype='multipart/form-data'>
                    <fieldset class="input-fields">
                    <?php foreach ($this->data['inputs'] as $key => $input): ?>

                      <?php if ($input['type'] == "hidden"): ?>
                        <input name="<?php echo $input['field'] ?>" type="hidden" value="<?php echo (isset($this->data[$this->data['item']]))? $this->data[$this->data['item']][$input['field']] : '';?>">
                      
                      <?php elseif ($input['type'] == "select"): ?>
                        <label class="control-label"><?php echo $input['head'] ?></label>
                        <div class="controls">

                          <select <?php echo $input['attributes'] ?> name="<?php echo $input['field'] ?><?php echo ($input['attributes'] == 'multiple')? '[]' : '' ?>" class="chosen" >
                            <?php foreach ($input['options'] as $option): ?>
                              <option value="<?php echo $option['id'] ?>" <?php echo ((isset($this->data[$this->data['item']]) && isset($this->data[$this->data['item']][$input['field']][$option['id']])) || $this->data[$this->data['item']][$input['field']] == $option['id'])? 'selected="selected"' : '';?>><?php echo $option['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>

                      <?php elseif ($input['type'] == "checkbox"): ?>
                        <label class="control-label"><?php echo $input['head'] ?></label>
                        <div class="controls">
                            <input name="<?php echo $input['field'] ?>" class="switch" type="<?php echo $input['type'] ?>"  <?php echo (isset($this->data[$this->data['item']]) && $this->data[$this->data['item']][$input['field']])? 'checked="checked"' : '';?>>
                        </div>

                      <?php elseif ($input['type'] == "img"): ?>
                        <div class="field-row">
                          <?php echo (isset($this->data[$this->data['item']]))? '<img class="control-label-img" src="'.$this->data[$this->data['item']][$input['field']].'" />' : '';?>
                          <div class="controls">
                              <input name="<?php echo $input['field'] ?>" type="file"  placeholder="">
                          </div>
                        </div>

                      <?php elseif ($input['type'] == "textarea"): ?>
                        <label class="control-label"><?php echo $input['head'] ?></label>
                        <div class="controls">
                            <textarea name="<?php echo $input['field'] ?>" placeholder="<?php echo $input['head'] ?>" class="many-cols">
                              <?php echo (isset($input['value']))? $input['value'] : "" ?><?php echo (isset($this->data[$this->data['item']]))? $this->data[$this->data['item']][$input['field']] : '';?>
                            </textarea>
                        </div>

                      <?php elseif ($input['type'] == "inc"): ?>

                        <?php
                          $value = (isset($input['value']))? $input['value'] : "";
                          $value .= (isset($this->data[$this->data['item']]))? $this->data[$this->data['item']][$input['field']] : '';
                        ?>

                        <label class="control-label"><?php echo $input['head'] ?></label>
                        <div class="controls">
                            <button class="optionizer icon icon-<?php echo (empty($value))? 'plus' : 'minus' ?>"></button>
                            <input name="<?php echo $input['field'] ?>" type="text" placeholder="<?php echo $input['head'] ?>" value="<?php echo $value ?>">
                            <input name="flag[]" class="flag-value" type="hidden" value="<?php echo (isset($input['flag']) && $input['flag'])? '1' : '0';?>">
                            <input name="flag-holder[]" class="yesno-switch" type="checkbox" <?php echo (isset($input['flag']) && $input['flag'])? 'checked="checked"' : '';?>>
                            
                        </div>

                      <?php else: ?>
                        <label class="control-label"><?php echo $input['head'] ?></label>
                        <div class="controls">
                            <input name="<?php echo $input['field'] ?>" type="<?php echo $input['type'] ?>"  placeholder="<?php echo $input['head'] ?>" value="<?php echo (isset($input['value']))? $input['value'] : "" ?><?php echo (isset($this->data[$this->data['item']]))? $this->data[$this->data['item']][$input['field']] : '';?>">
                        </div>
                      <?php endif ?>

                    <?php endforeach ?>

                    </fieldset>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Save</button>
                          <a class="btn" href="/backend/<?php echo $this->data['table']; ?>">Back</a>
                      </div>

                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>