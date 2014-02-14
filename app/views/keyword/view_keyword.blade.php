@section('content')

<div style="background-color:#fff;width:100%;margin-left:0px;padding:5px;box-shadow: 1px 1px 1px 0px #d0d0d0;">
	<div style="width:1025px;margin:0px auto;">
		<!-- <div style="float:left"><img class="fb-pic" src="" style="height:100px;width:100px;border:3px solid #fff"></div> -->
		<div style="float:left;margin-left:10px;color:#333;margin-top:-10px">
			<h3 style="line-height:30px"><?php echo $keyword ; ?></h3>
			<div style="font-size:15px;"><strong><?php echo $count; ?></strong> times referred</div>
			<div style="font-size:15px;"><strong><?php echo count($user_list); ?></strong> engaged users</div>
		</div>
		<div style="float:right">
			<a href="<?php echo url('/keyword/post/'.$keyword.''); ?>" class="btn btn-primary btn-large" style="margin-top:25px;margin-right:10px;">View Post</a>

			<a href="<?php echo url('/keyword/graph/'.$keyword.''); ?>" class="btn btn-success btn-large" style="margin-top:25px;margin-right:20px;">View Graph</a></div>
		<div style="clear:both"></div>
	</div>
</div>

<div style="width:1025px;margin:0px auto;">
	<br/>
	<?php foreach($user_list as $each):?>
		<a href="<?php echo url('view',$each->fid); ?>">
		<div class="block" id="<?php echo $each->fid ; ?>">
		<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->fid ; ?>/picture?type=square" ></div>
		<div class="block-name"><?php echo $each->username; ?> <?php //echo $user_frequency[$each->fid]; ?></div>
		</div>
		</a>
	<?php endforeach ?>

	<div style="clear:both"></div>
</div>

@endsection