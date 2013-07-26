<html>
<head>
    <title>
        Error-Validation
    </title>
</head>
<body>
<?php
foreach($this->error_field as $field){
    foreach($this->validation_errors[$field] as $error){
        echo $error.'<br>';
    }
}
 ?>
</body>
</html>