<div class="panel widget light-widget panel-bd-top">
	<div class="panel-heading no-title">
		<h4>
			<a href="#" onClick="displayQualification()">
	            <center><b> Category</b>
	                <i class="pull-right glyphicon glyphicon-chevron-down" id="icon_qualification"></i>
	            </center>
	        </a>
	    </h4> 
	</div>
	<div class="panel-body tags" id="qualification" style="display:block">
			<ul class="nav nav-pills nav-stacked">
				<?php foreach($categories as $id=>$event){ ?>
				<li>
					<a href="/service/service-event/index?type=category&search=<?php echo $id ?>">
						<span class="pull-right">(<?= $searchModel->count($id);?>)</span>
						<?php echo $event ?>
					</a>
				</li>

				<?php } ?>
			</ul>
	</div>
</div>

<script>
    function displayQualification(){
        if(document.getElementById('qualification').style.display == 'none'){
            $('#qualification').show();
            $('#icon_qualification').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }else{
            $('#qualification').hide();
            $('#icon_qualification').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }   
    }
</script>
	