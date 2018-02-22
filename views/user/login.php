<?php include ROOT . '/views/layout/header.php' ?>

<section class="masthead text-center text-white">
    <div class="masthead-content">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Enter email and password</small></h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="#" method="post">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control input-sm"
                                           placeholder="Email Address">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control input-sm"
                                           placeholder="Password">
                                </div>

                                <input type="submit" name="submit" value="Login" class="btn btn-info btn-block">
	                            <?php if (isset($errors['login']) && $errors['login']): ?>
                                    <span class="error"><?= $errors['login']; ?></span>
	                            <?php endif; ?>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-circle-1 bg-circle"></div>
    <div class="bg-circle-2 bg-circle"></div>
    <div class="bg-circle-3 bg-circle"></div>
    <div class="bg-circle-4 bg-circle"></div>
</section>

<?php include ROOT . '/views/layout/footer.php' ?>

