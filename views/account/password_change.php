<?php include ROOT . '/views/layout/header.php'; ?>
    <section class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Change your password</small></h3>
                            </div>
                            <div class="panel-body">
                                <form role="form" action="#" method="post">
                                    <div class="form-group">
                                        <input type="password" name="old_password" id="old_password" class="form-control input-sm" placeholder="Enter Old Password">
		                                <?php if (isset($errors['old_password']) && $errors['old_password']):?>
                                            <span class="error"><?= $errors['old_password']; ?></span>
		                                <?php endif; ?>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="password" pattern=".{6,}" required title="6 characters minimum"  name="password" id="password" class="form-control input-sm" placeholder="New Password">
	                                    <?php if (isset($errors['password']) && $errors['password']):?>
                                            <span class="error"><?= $errors['password']; ?></span>
	                                    <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" pattern=".{6,}" required title="6 characters minimum" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm New Password">
	                                    <?php if (isset($errors['password_confirmation']) && $errors['password_confirmation']):?>
                                            <span class="error"><?= $errors['password_confirmation']; ?></span>
	                                    <?php endif; ?>
                                    </div>

                                    <input type="submit" name="submit" value="Change Password" class="btn btn-info btn-block">
                                    <?php if ($result): ?>
                                    <h3 class="panel-title">Password was changed</small></h3>
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
<?php include ROOT . '/views/layout/footer.php'; ?>