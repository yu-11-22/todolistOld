<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href='style.css'>
    <title><?php echo $title ?></title>
</head>

<body>
    <div class=<?php echo $headerClass ?>>
        <?php echo $header ?>
    </div>
    <div class=<?php echo $contentClass ?>>
        <?php echo $content ?>
    </div>
    <div class=<?php echo $footerClass ?>>
        <?php echo $footer ?>
    </div>
</body>

</html>