@section('content')
<div style=";padding:5px;margin-bottom:0px">
	<div class="body">
		<div style="color:#333;font-size:20px;font-weight:bold;margin-bottom:5px">Mutual Interests</div>
		<a href="<?php echo url('view',$user1->fid); ?>">
		<div class="block" id="<?php echo $user1->fid ; ?>">
			<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $user1->fid ; ?>/picture?type=square" ></div>
			<div class="block-name">
				<?php echo $user1->username; ?>
			</div>
		</div>
		</a>


		<a href="<?php echo url('view',$user2->fid); ?>">
		<div class="block" id="<?php echo $user2->fid ; ?>">
			<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $user2->fid ; ?>/picture?type=square" ></div>
			<div class="block-name">
				<?php echo $user2->username; ?>
			</div>
		</div>
		</a>
		<div style="clear:both"></div>
	</div>
</div>
<hr class="body" style="margin-bottom:10px">
<div class="body" style="margin-top:0px">
		<div style="color:#333;font-size:20px;font-weight:bold;margin-bottom:10px">Keyword</div>
		<?php if(count($intersect) == 0 ):?>
			<span style="font-weight:bold;color:#999">no mutual keywords</span>
		<?php endif ?>
<?php foreach($intersect as $each): ?>
	<a href="<?php echo url('keyword',$each->name); ?>">
	<div class="mutual-block">
		<span style="font-size:20px;color:#333"><?php echo $each->name ; ?></span>
		<div style="float:right;font-weight:bold"><?php echo $each->max ; ?></div>
		<br/><br/>
		<div style="font-weight:bold;color:#666;float:right;margin-left:5px"><?php printf("%.2f%%",$each->ratio); ?></div>
		<div class="progress progress-striped">
			<?php if($each->ratio > 50) $str="success" ;?>
			<?php if($each->ratio <= 50) $str = "info" ;?>
			<div class="progress-bar progress-bar-<?php echo $str ;?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $each->ratio ; ?>%;">
			</div>
		</div>
	</div>
	</a>
<?php endforeach ?>	
</div>
@endsection