<div class="tournament">
	<?php
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>CHtml::link('Snooker', array('site/index')),
		    'links'=>array('Tournament'),
		));
	?>
	<div class="table-data">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tournament</th>
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
					<td><?php echo $value['TournamentName']; ?></td>
					<td class="center"><label class="label <?php echo $arrStatus[$value['TournamentStatus']]; ?>"><?php echo $value['TournamentStatus']; ?></label></td>
					<td>
						<input type="button" class="btn btn-info" value="Edit">
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