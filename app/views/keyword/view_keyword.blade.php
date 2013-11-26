@section('content')

<div style="background-color:#0099cc;width:100%;margin-left:0px;margin-top:-9px;padding:5px">
	<div style="float:left"><img class="fb-pic" src="" style="height:100px;width:100px;border:3px solid #fff"></div>
	<div style="float:left;margin-left:10px;color:#fff;">
		<h3 style="line-height:30px"><span style="color:#333">Keyword</span><br/><?php echo $keyword ; ?></h3>
	</div>
	<div style="float:right">
		<a href="<?php echo url('/keyword/graph/'.$keyword.''); ?>" class="btn btn-info" style="margin-top:25px;margin-right:20px;width:200px;height:50px;font-size:20px;padding:10px">View Graph</a></div>
	<div style="clear:both"></div>
</div>

<div style="background-color:#e0e0e0;width:100%;margin-left:0px;padding:15px">
<?php /*for($i=0;$i<count($keyword_list);$i++):?>
	<?php if(!$remove[$i]): ?>
		<a href="" class="btn btn-primary" style="margin-right:5px;margin-top:5px"><?php echo $keyword_list[$i]->name; ?> - <?php echo $frequency[$i] ; ?></a>
	<?php endif ?>
<?php endfor*/ ?>
<h3>Talked (<?php echo $count[0]->total; ?>)</h3>
<h3>Engaged User (<?php echo count($user_list); ?>)</h3><br/>
<?php foreach($user_list as $each):?>
	<a href="<?php echo url('view',$each->fid); ?>">
	<div class="block" id="<?php echo $each->fid ; ?>">
	<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->fid ; ?>/picture?type=square" ></div>
	<div class="block-name"><?php echo $each->username; ?> <?php echo $user_frequency[$each->fid]; ?></div>
	</div>
	</a>
<?php endforeach ?>
</div>

@endsection