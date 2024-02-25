<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Controller Index View</title>
</head>
<body>
    <h1>Home Controller Index View Data</h1>
    <?php 
    
    ?>
    <ul>
        <?php foreach($tests as $test): ?>
            <li><?= $test->name ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
