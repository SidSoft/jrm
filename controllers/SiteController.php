<?php
namespace controllers;

class SiteController {

	/*
	 * Manages site title page
	 */
	public function actionIndex() {

		$pageTitle = 'JustRegMe';
		require_once(ROOT . '/views/site/index.php');

		return true;
	}

}