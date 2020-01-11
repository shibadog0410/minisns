<?php $this->setLayouVar('title', $status['user_name']) ?>
<?php echo $this->render('status/status', array('status' => $status)); ?>