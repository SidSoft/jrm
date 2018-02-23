<?php
return array(
	'register' => 'user/register', //actionRegister in UserController
	'login' => 'user/login', //actionLogin in UserController
	'logout' => 'user/logout', //actionLogout in UserController
	'account/accept/(.{32})' => 'account/accept/$1', //actionAccept in AccountController
	'account/edit' => 'account/edit', //actionEdit in AccountController
	'account/ch_pass' => 'account/passwordChange', //actionPasswordChange in AccountController
	'account/new_conf' => 'account/sendConfirmationEmail', //actionSendConfirmationEmail in AccountController
	'account' => 'account/index', //actionIndex in AccountController
	'/?$' => 'site/index', // actionIndex in SiteController
);