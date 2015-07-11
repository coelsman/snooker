<?php
class widget_pagination extends CWidget {
	public $totalRecord, $recordPerPage, $link, $valQuery = 'page';
	public function run() {
		$this->render('widget_pagination', array(
			'totalRecord'=>$this->totalRecord, 
			'recordPerPage'=>$this->recordPerPage, 
			'link'=>$this->link, 
			'valQuery'=>$this->valQuery
		));
	}
}
?>