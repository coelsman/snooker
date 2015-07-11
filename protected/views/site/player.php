<style type="text/css">
	.player #popup-add-player .row-form {
		margin-bottom: 4px;
	}
	.player #popup-add-player .title {
		width: 33%;
		margin-right: 2%;
		text-align: right;
		margin-top: 8px;
	}
	.player #popup-add-player .form-field {
		width: 45%;
		margin-right: 20%;
	}
	.player #popup-add-player #alert-popup {
		width: 60%;
  		margin: 10px 20%;
	}
</style>
<div class="player">
	<?php
		$this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink'=>CHtml::link('Snooker', array('site/index')),
		    'links'=>array('Player'),
		));
	?>
	<div style="margin:5px 0;">
		<input type="button" value="Add Player" class="btn btn-info" id="btn-open-popup">
	</div>
	<div class="table-data">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Player</th>
					<th>Avatar</th>
					<th>National</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php  
					if ($data) {
						if (Yii::app()->request->getQuery('page')) {
							$page = Yii::app()->request->getQuery('page');
						} else {
							$page = 1;
						}
						$i = ($page - 1) * 15 + 1;
						foreach ($data as $key => $value) {
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $value['PlayerName']; ?></td>
					<td></td>
					<td><?php echo $value['NationalName']; ?></td>
					<td class="center"><label class="label <?php echo $arrStatus[$value['StatusName']]; ?>"><?php echo $value['StatusName']; ?></label></td>
					<td>
						<input type="button" class="btn btn-primary" value="Edit">
						<input type="button" class="btn btn-danger" value="Delete">
					</td>
				</tr>
				<?php 
						$i++;
					}} 
				?>
			</tbody>
		</table>
	</div>
	<?php $this->widget('widget_pagination', array('totalRecord'=>$countPlayer, 'recordPerPage'=>15, 'link'=>'site/player')); ?>
	<div class="modal fade" id="popup-add-player" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="alert-popup"></div>
				<div class="modal-body">
					<div class="row-form">
						<div class="title pull-left">Player Name</div>
						<input type="text" class="form-control pull-left form-field" id="txt-player-name">
						<div class="clearfix"></div>
					</div>
					<div class="row-form">
						<div class="title pull-left">Nationality</div>
						<select class="form-control pull-left form-field" id="slc-national">
							<option value="-1">---------Choose National---------</option>
							<?php foreach ($listNational as $key => $value) { ?>
								<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
							<?php } ?>
						</select>
						<div class="clearfix"></div>
					</div>

				</div>
				<div class="modal-footer">
					<input type="button" id="btn-save" class="btn btn-primary" value="Save">
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
<script type="text/javascript">
	$('#btn-open-popup').on('click', function () {
		$('#popup-add-player').modal('show');
		$('#popup-add-player').on('shown.bs.modal', function () {
			$('#txt-player-name').focus();
		});
	});

	$('#btn-save').on('click', function () {
		var pName = $('#txt-player-name').val();
		var nID = $('#slc-national option:selected').val();

		if (pName == '') {
			$('#alert-popup').removeClass().addClass('alert alert-danger').html('Name can not be blank.');
			return;
		}
		if (nID == '-1') {
			$('#alert-popup').removeClass().addClass('alert alert-danger').html('You must select national for player.');
			return;
		}

		$.ajax({
			url: baseUrl + 'site/addPlayer',
			type: 'POST',
			async: true,
			data: {
				pName: pName,
				nID: nID
			},
			success: function (json) {
				if (json == 'OK') {
					$('#alert-popup').removeClass().addClass('alert alert-success').html(pName+' has been created.');
				} else if (json == 'EXIST') {
					$('#alert-popup').removeClass().addClass('alert alert-warning').html(pName+' created before.');
				}
			}
		});
	});
</script>