<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiwTter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-Ps8vggxuHpTnIT+9mL6fRz3gpv5QZ61Izg8HMudwFbHPZM8W3GTpRvRsQtXBSgJI" crossorigin="anonymous"> -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <style>

        a{
            text-decoration: none;
            color: #000;
            cursor: pointer;
            margin: 0 10px;
        }

        .main img{
            width: 100%;
            height: 250px;
            border-radius: 15px;
            object-fit: cover;
        }

    </style>
</head>
<body>
    <?= $this->renderSection('content') ?>
</body>
</html>