<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/template/css/style.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">JustRegMe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
		        <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <span class="nav-link nav-name"><?php echo \models\User::getUserName($_SESSION['user'])?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/account">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Log Out</a>
                    </li>
		        <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Log In</a>
                    </li>
		        <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

