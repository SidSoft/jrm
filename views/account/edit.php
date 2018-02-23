<?php include ROOT . '/views/layout/header.php'; ?>
    <section class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit user details</small></h3>
                            </div>
                            <div class="panel-body">
                                <form role="form" action="#" method="post">
                                    <div class="form-group">
                                        <input type="text" pattern=".{2,}" required title="2 characters minimum" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name" value="<?= $first_name; ?>">
	                                    <?php if (isset($errors['first_name']) && $errors['first_name']): ?>
                                            <span class="error"><?= $errors['first_name']; ?></span>
	                                    <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" pattern=".{2,}" required title="2 characters minimum" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name" value="<?= $last_name; ?>">
	                                    <?php if (isset($errors['last_name']) && $errors['last_name']): ?>
                                            <span class="error"><?= $errors['last_name']; ?></span>
	                                    <?php endif; ?>
                                    </div>

                                    <input type="submit" name="submit" value="Edit" class="btn btn-info btn-block">
                                    <?php if ($result): ?>
                                    <h3 class="panel-title">Data was changed</small></h3>
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