<div id="displayAll" class="panel widget light-widget panel-bd-top">
	<div class="panel-heading no-title">
		<h4>
			<a href="#" onClick="displayDistrict()">
				<center><b> District</b>
					<i class="pull-right glyphicon glyphicon-chevron-down" id="icon_district"></i>
				</center>
			</a>
		</h4> 
	 </div>
	<div class="panel-body tags" id="district" style="display:block">
			<ul class="nav nav-pills nav-stacked">
				<?php foreach($districts as $id=>$district){ ?>
				<li>
					<a href="<?= Yii::$app->link->frontendUrl('/service/service-event/index?type=district&search'.$id)?>">
						<span class="pull-right">(<?= $searchModel->countdistrict($id);?>)</span>
						<?php echo $district ?>
					</a>
				</li>

				<?php } ?>
			</ul>
		<?php if(!isset($_GET['displayAll'])){ ?>
			<a href="<?= Yii::$app->link->frontendUrl('/service/service-event/index?displayAll#displayAll')?>"><span class="pull-right" style="color:blue">
				Display All 
				<i class="glyphicon glyphicon-chevron-down"></i></span></a>
		<?php } else { ?>
			<a href="<?= Yii::$app->link->frontendUrl('/service/service-event/index#displayAll')?>"><span class="pull-right" style="color:blue">
				Show Less
			<i class="glyphicon glyphicon-chevron-up"></i></span></a>
		<?php } ?>
	</div>
</div>
<script>
	function displayDistrict(){
		if(document.getElementById('district').style.display == 'none'){
			$('#district').show();
			$('#icon_district').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}else{
			$('#district').hide();
			$('#icon_district').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		}	
	}
</script>
	