@section('content')
<div style="padding:10px;background-color:#fff;width:100%;float:left;margin-bottom:10px;">
	<div class="body">
		<span style="color:#999;font-weight:bold">Statistic</span><br/>
		<span style="font-size:20px;font-weight:bold"><?php echo count($tag_list); ?> total keywords</span>
	</div>
</div>
<div style="clear:both"></div>

<div class="body">
	<?php foreach($tag_list as $each): ?>
		<a href="<?php echo url('keyword',$each->name); ?>">
		<div class="keyword-block"><div class="keyword-block-rank"><?php echo $each->total ; ?></div><?php echo $each->name ; ?></div>
		</a>
	<?php endforeach ?>
	<div style="clear:both"></div>
</div>
@endsection