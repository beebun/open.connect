@section('content')


<div style="background-color:#fff;width:100%;padding:5px;box-shadow: 1px 1px 1px 0px #d0d0d0;">
	<div class="body">
	<span style="font-size:20px">Home</span>
	</div>
</div>

<div class="body" style="margin-top:10px;">

	<div style="width:57%;float:left;padding:10px;background-color:#fff;margin-right:10px;box-shadow: 1px 1px 1px 0px #d0d0d0;">
		<div style="font-size:20px;margin-bottom:10px">Suggested Keywords</div>
		<?php $i = 1; ?>
		<?php foreach($keyword_list as $each): ?>
			<div style="width:100%;padding:10px;background-color:#f5f5f5;margin-bottom:5px">
				<span style="font-size:20px"><strong><?php echo $i ++ ; ?></strong> - <?php echo $each->name; ?>
				<a href="{{ url('/keyword/'.$each->name) }}" class="btn btn-primary pull-right">View</a></span>
			</div>
		<?php endforeach ?>
		<div style="clear:both"></div>
	</div>


	<div style="width:42%;float:left;background-color:#fff;padding:10px;box-shadow: 1px 1px 1px 0px #d0d0d0;">
		<div style="font-size:20px;margin-bottom:10px">Top User</div>
		<?php foreach($rank as $each): ?>
			<a href="<?php echo url('view',$each->fid); ?>">
			<div class="block-flat" id="<?php echo $each->fid ; ?>">
			<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->fid ; ?>/picture?type=square" ></div>
			<div class="block-name"><?php echo $each->username; ?></div>
			</div>
			</a>
		<?php endforeach ?>
		<div style="clear:both"></div>
	</div>

	<div style="clear:both"></div>

</div>



@endsection