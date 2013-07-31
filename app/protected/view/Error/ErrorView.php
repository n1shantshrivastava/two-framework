<?php $this->title='Error view'?>
<?php $this->fetch('header'); ?>
    <h1>Whoops an error has occurred.</h1>
    <h3>Error:</h3>
    <?php echo $this->msg;?>
    <h3>File Name:</h3>
    <?php echo $this->file_name;?>
    <h3>Line No:</h3>
    <?php echo $this->line_no;?>
<?php $this->fetch('footer'); ?>