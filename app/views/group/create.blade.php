@section('content')


<div style="padding:10px;background-color:#fff;width:100%;float:left;margin-bottom:10px;position:fixed">
<div class="body"><span style="color:#999;font-weight:bold">Create Group</span><br/>
</div></div>
<br/><br/>

<div class="body" style="background-color:#fff;margin-top:10px">
	{{ Form::open(array('url' => 'group/create')) }}
	<table class="table">
	<tr>
		<td>Group Name</td>
		<td><input type="text" name="name" class="form-control" style="width:300px"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="create" class="btn btn-primary"></td>
	</tr>
	</table>
	{{ Form::close() }}

</div>

@endsection