@section('content')

<style type="text/css">
	.group-box{
		box-shadow: 1px 1px 1px 0px #d0d0d0;
		padding:10px;
		background-color:#fff;
		float:left;
		width:300px;
		margin-right:5px;
		margin-top:5px;
	}
</style>

<div style="padding:10px;background-color:#fff;width:100%;float:left;margin-bottom:10px;position:fixed">
<div class="body"><span style="color:#999;font-size:30px" class="head1">{{ $group->name }}</span>

<span class="pull-right">
<a href="{{ url('group/') }}" class="btn btn-default">Back</a>
<a href="{{ url('group/delete/'.$group->id) }}" class="btn btn-danger">Delete</a>
</span>
</div></div>
<br/><br/><br/><br/>
<div class="body">
@if(count($keywords) == 0)
<span class="empty">empty</span>
@else
<span><strong>Keyword</strong></span>
<div class="clear"></div>
@foreach($keywords as $keyword)
	@if($keyword->keyword)
	<a href="<?php echo url('keyword',$keyword->keyword->name); ?>" class="row1">
		<div class="block keyword-block">
			<div class="keyword-block-rank"><?php echo $keyword->keyword->total ; ?></div>
			<?php echo $keyword->keyword->name ; ?>
		</div>
	</a>
	@endif
@endforeach

<div style="clear:both;"></div>
<div style="margin-top:10px">
<span class="pull-left"><strong>User</strong></span>
<div style="clear:both"></div>
@foreach($users as $user)
	<div class="block" >
		<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $user->fid ; ?>/picture?type=square" ></div>
		<div class="block-name">
			<?php echo $user->username; ?>
		</div>
	</div>
@endforeach

</div>

@endif

</div>

@endsection