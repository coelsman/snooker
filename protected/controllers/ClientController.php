<?php 
class ClientController extends Controller {
	public $layout = 'client';
	public function actionIndex() {
		$liveMatches = Match::model()->listMatchesByStatus(2);
		$this->render('index', array(
			'liveMatches' => $liveMatches
		));
	}
}
?>