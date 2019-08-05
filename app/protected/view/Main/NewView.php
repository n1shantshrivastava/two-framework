<!doctype html>
<html>
<head>
    <title>
        New View
    </title>

</head>
<body>
<h3>
    new view
</h3>
<?php
    foreach($this->rows as $row){
        echo '<br>Name='.$row['fname'];
    }
?>
</body>
</html>