<?php include ROOT . '/views/layout/header.php' ?>

<section class="masthead text-center text-white">
    <div class="masthead-content">
        <?php if (!$confirmed): ?>
        <div class="container">
            <h1 class="masthead-heading mb-0">Thanks for signing up!</h1>
            <h4 class="masthead-subheading mb-0">To activate account you must confirm your email address</h4>
            <div id="okAlert" class="alert alert-success alert-dismissible collapse" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Well done!</strong> Now you can check your email account.
            </div>
            <div id="wrongAlert" class="alert alert-danger alert-dismissible collapse" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Oops!</strong> Unable to send email.
            </div>
            <a class="btn btn-primary btn-xl rounded-pill mt-5" id="confirmAgain">Send confirmation email again</a>
        </div>
	    <?php else: ?>
        <div class="container">
            <h1 class="masthead-heading mb-0">Hello, <?= $userName; ?>!</h1>
            <a class="btn btn-primary btn-xl rounded-pill mt-5" id="editDetails">Edit your account details</a>
            <a class="btn btn-primary btn-xl rounded-pill mt-5" id="changePassword">Change password</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="bg-circle-1 bg-circle"></div>
    <div class="bg-circle-2 bg-circle"></div>
    <div class="bg-circle-3 bg-circle"></div>
    <div class="bg-circle-4 bg-circle"></div>
</section>

<?php include ROOT . '/views/layout/footer.php' ?>
