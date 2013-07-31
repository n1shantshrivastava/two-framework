<?php $this->title='My view'?>
<?php $this->fetch('header'); ?>
<h3>
    new view
</h3>
<?php
    foreach($this->rows as $row){
        echo 'Name='.$row['fname'];
    }
?>

<?php $this->fetch('footer'); ?>