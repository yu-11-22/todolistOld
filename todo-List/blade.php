<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='todolist.css'>
    <title><?php echo $title ?></title>
</head>

<body>
    <div class="header">
        <?php echo $inputTodoTitle ?>
        <?php echo $inputTodo ?>
        <?php echo $alert ?>
    </div>
    <div class="content">
        <?php echo $content ?>
    </div>
</body>

</html>