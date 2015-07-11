<div class="season">
	<?php
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>CHtml::link('Snooker', array('site/index')),
		    'links'=>array('Season'),
		));
	?>
	<div class="table-data">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Season</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php  
					if ($data) {
						$i = 1;
						foreach ($data as $key => $value) {
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $value['SeasonName']; ?></td>
					<td class="center"><label class="label <?php echo $arrStatus[$value['SeasonStatus']]; ?>"><?php echo $value['SeasonStatus']; ?></label></td>
					<td>
						<a href="<?php echo Yii::app()->createUrl('site/season', array('sID'=>$value['SeasonID'], 't'=>'tournament')); ?>" class="btn btn-primary">Tournament</a>
						<input type="button" class="btn btn-info" value="Player">
						<input type="button" class="btn btn-warning" value="Edit">
						<input type="button" class="btn btn-danger" value="Remove">
					</td>
				</tr>
				<?php 
						$i++;
					}} 
				?>
			</tbody>
		</table>
	</div>
</div>