@section('content')

<div style="margin-left:10px">
<div style="float:right"><input type="text" class="form-control" placeholder="Find user"></div>
<div style="padding:10px;background-color:#fff;width:200px;float:left;margin-bottom:10px">
<span style="color:#999;font-weight:bold">Statistic</span><br/>
<span style="font-size:20px;font-weight:bold"><?php echo count($user_list); ?> total users</span>
</div>
<div style="clear:both"></div>
<?php foreach($user_list as $each): ?>
	<a href="<?php echo url('view',$each->fid); ?>">
	<!-- <div class="block" id="<?php echo $each->fid ; ?>"></div> -->

	<div class="block" id="<?php echo $each->fid ; ?>">
	<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->fid ; ?>/picture?type=square" ></div>
	<div class="block-name"><?php echo $each->username; ?></div>
	</div>

	</a>
<?php endforeach ?>
</div>




<script type="text/javascript">
	// $.each($('.block'), function() {
	// 	$("#"+this.id).html("<span class='loading'>loading...</span>");
	// 	$("#"+this.id).load("get_user_data/"+this.id);
	// });
</script>

@endsection