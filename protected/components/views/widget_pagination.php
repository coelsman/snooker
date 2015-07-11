<nav>
	<ul class="pagination">
		<?php
			$nowPage = 1;
			if (Yii::app()->request->getQuery($valQuery)) {
				$nowPage = Yii::app()->request->getQuery($valQuery);
			}
			if ($recordPerPage > 0) {
				if ($nowPage > 1) {
					echo '<li>'.CHtml::link('First', Yii::app()->createUrl($link, array($valQuery=>1)), array('class'=>'')).'</li>';
					echo '<li>'.CHtml::link('Prev', Yii::app()->createUrl($link, array($valQuery=>$nowPage - 1)), array('class'=>'')).'</li>';
				}
				$range = 3;
				$page = ceil($totalRecord/$recordPerPage);
				$min = $nowPage - $range; 
				$max = $nowPage + $range;
				if ($min < 1) $min = 1;
				if ($max > $page) $max = $page;
				
				for ($i=$min; $i<=$max; $i++) {
					if ($i == $nowPage) {
						$class = 'active';
						$newLink = '';
					}
					else {
						$class = '';
						$newLink = Yii::app()->createUrl($link, array($valQuery=>$i));
					}
					echo '<li class="'.$class.'">'.CHtml::link($i, $newLink).'</li>';
				}
				if ($nowPage < $page) {
					echo '<li>'.CHtml::link('Next', Yii::app()->createUrl($link, array($valQuery=>$nowPage + 1)), array('class'=>'')).'</li>';
					echo '<li>'.CHtml::link('Last', Yii::app()->createUrl($link, array($valQuery=>$page)), array('class'=>'')).'</li>';
				}
			}
		?>
	</ul>
	<div class="notify"><?php echo 'Page '.$nowPage.' in total '.$page.' pages.' ?></div>
</nav>