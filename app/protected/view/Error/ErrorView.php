<<<<<<< HEAD:app/protected/view/Error/ErrorView.php
<?php $this->title='Error view'?>
<?php $this->fetch('header'); ?>
=======
<html>
    <head>
        <title>whoops an error has occurred</title>
    <link rel="stylesheet" type="text/css" href="../../global/css/error.css">
    </head>
    <body>
>>>>>>> 5623450d7b5a664eee4960217cff4eae2443be8e:app/protected/view/ErrorView.php
    <h1>Whoops an error has occurred.</h1>
    <img src="../../global/img/error_by_charmingice-d47894f.png" height="75" width="200"><br><br>
    <label><?php echo $this->msg;?></label>
    <h3>File Name:</h3>
    <label><?php echo $this->file_name;?></label>
    <h3>Line No:</h3>
<<<<<<< HEAD:app/protected/view/Error/ErrorView.php
    <?php echo $this->line_no;?>
<?php $this->fetch('footer'); ?>
=======
    <label><?php echo $this->line_no;?></label>
    </body>
</html>
>>>>>>> 5623450d7b5a664eee4960217cff4eae2443be8e:app/protected/view/ErrorView.php
