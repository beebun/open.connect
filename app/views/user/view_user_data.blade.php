@section('content')
<style type="text/css">
	.user-tag-block:hover{
		background-color: #fff;
	}
</style>
<div style="background-color:#fff;width:100%;margin-left:0px;padding:10px">
	<div class="body">
		<div style="float:left">
			<img class="fb-pic" src="http://graph.facebook.com/<?php echo $fid ; ?>/picture?type=large" style="height:100px;border:1px solid #999"></div>
		<div style="float:left;margin-left:10px;color:#333;margin-top:-10px">
			<h3 style="line-height:30px"><?php echo $user_data[0]->username ; ?></h3>
			<div style="font-size:15px;"><strong><?php echo count($tag_list); ?></strong> relevant keywords</div>
		</div>
		<div style="float:right;margin-right:20px;margin-top:20px">
			<!-- <a href="" class="btn btn-primary btn-large" > -->
				<!-- View Facebook Account -->
				<!-- <img src="http://www.underconsideration.com/brandnew/archives/facebook_logo_detail.gif" style="width:70px;margin-top:12px;margin-right:20px"> -->
			<!-- </a> -->
		</div>
		<div style="clear:both"></div>
	</div>
</div>

<div class="body" style="margin-top:10px">
	<div style="background-color:#e0e0e0;width:100%;margin-left:0px;">
	<?php $i=0; ?>
	<?php foreach($tag_list as $each): ?>
			<a href="<?php echo url('keyword',$each->name); ?>">
			<div class="user-tag-block" style="box-shadow: 1px 1px 1px 0px #d0d0d0;width:200px;padding:10px;height:100px;background-color:#efefef;float:left;margin-right:5px;margin-bottom:5px">
				<span style="font-size:18px;color:#333"><?php echo $each->name ; ?></span>
				<div style="float:right;font-weight:bold"><?php echo $each->user_frequency ; ?></div>
				<br/><br/>
				<div style="font-weight:bold;color:#666;float:right;margin-left:5px"><?php printf("%.2f%%",$each->ratio); ?></div>
				<div class="progress progress-striped">
				  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $each->ratio; ?>%;">
				  </div>
				</div>
			</div>
			</a>
	<?php endforeach ?>
	<div style="clear:both"></div>
	</div>
</div>

@endsection