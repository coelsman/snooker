<div class="seasonTournament">
	<?php
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>CHtml::link('Snooker', array('site/index')),
		    'links'=>array(
		    	'Season'=>array('site/season'),
		    	$season['SeasonName']
		    )
		));
	?>
	<div class="table-data">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tournament Base Name</th>
					<th>Tournament Name</th>
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
					<td><?php echo $value['TournamentBaseName']; ?></td>
					<td><?php echo $value['TournamentName']; ?></td>
					<td class="center">
					<?php if ($value['TournamentStatus'] != ''): ?>
						<label class="label <?php echo $arrStatus[$value['TournamentStatus']]; ?>"><?php echo $value['TournamentStatus']; ?></label></td>
					<?php endif; ?>
					<td>
						<?php if ($value['TournamentName'] == '') { ?>
							<input type="button" class="btn btn-primary" value="Add">
						<?php } else { ?>
							<a class="btn btn-default">View</a>
							<a href="<?php echo Yii::app()->createUrl('site/season', array('sID'=>$season['SeasonID'], 'tID'=>$value['TournamentID'])) ?>" class="btn btn-info">Update</a>
							<a class="btn btn-danger">Remove</a>
						<?php } ?>
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