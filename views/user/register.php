<?php include ROOT . '/views/layout/header.php' ?>

<section class="masthead text-center text-white">
    <div class="masthead-content">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please sign up <small>It's free!</small></h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="#" method="post">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" pattern=".{2,}" required title="2 characters minimum" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name" value="<?= $first_name; ?>">
	                                        <?php if (isset($errors['first_name']) && $errors['first_name']): ?>
                                                <span class="error"><?= $errors['first_name']; ?></span>
	                                        <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" pattern=".{2,}" required title="2 characters minimum" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name" value="<?= $last_name; ?>">
	                                        <?php if (isset($errors['last_name']) && $errors['last_name']): ?>
                                                <span class="error"><?= $errors['last_name']; ?></span>
	                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address" value="<?= $email; ?>">
	                                <?php if (isset($errors['email']) && $errors['email']):?>
                                        <span class="error"><?= $errors['email']; ?></span>
	                                <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="password" pattern=".{6,}" required title="6 characters minimum"  name="password" id="password" class="form-control input-sm" placeholder="Password">
	                                        <?php if (isset($errors['password']) && $errors['password']):?>
                                                <span class="error"><?= $errors['password']; ?></span>
	                                        <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="password" pattern=".{6,}" required title="6 characters minimum" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
	                                        <?php if (isset($errors['password_confirmation']) && $errors['password_confirmation']):?>
                                                <span class="error"><?= $errors['password_confirmation']; ?></span>
	                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" name="submit" value="Register" class="btn btn-info btn-block">

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

