<?php
namespace controllers;

class SiteController {

	public function actionIndex() {

		$pageTitle = 'JustRegMe';
		require_once(ROOT . '/views/site/index.php');

		return true;
	}

}