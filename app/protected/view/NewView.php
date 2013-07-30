<html>
<head>
    <title>new view</title>
</head>
<body>
<?php
foreach($this->rows as $row){
    foreach($row as $key=>$value){
        echo "$key=>$value <br>";
    }
    echo '<hr>';
}
?>
<br>
</body>
</html>
