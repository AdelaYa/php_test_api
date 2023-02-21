<?php
use Core\BaseView;
/** @var BaseView $this */
print_r($_GET);
echo '$_GET<br>';





?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <link rel='stylesheet' href='../style.css'/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>MVC</title>
</head>
<body>

    <?php
    $this->renderContent(); ?>
</body>
</html>