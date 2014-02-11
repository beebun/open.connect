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
<div class="body"><span style="font-size:20px;color:#999">Group</span>
<span class="pull-right"><a href="{{ url('group/create') }}" class="btn btn-primary">Create Group</a></span><br/>
</div></div>
<br/><br/><br/><br/>
<div class="body">
	@foreach($groups as $group)
		<div class="group-box">
		<strong style="font-size:20px"><a href="{{ url('group/view/'.$group->id) }}">{{ $group->name }}</a></strong><br/> 
		Total Keywords: {{ $group->total_keyword }}<br/>
		</div>
	@endforeach
	@if(count($groups) == 0)
		<span class="empty">empty</span>
	@endif

</div>

@endsection