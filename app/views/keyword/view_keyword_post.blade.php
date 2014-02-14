@section('content')

<div class="body" style="padding:10px">
	<div class="head1" style="margin-top:10px;margin-bottom:10px">Post Related to "{{ $name }}" <span class="pull-right">Total {{ count($posts)}}</span></div>
	@foreach($posts as $each)
		<div style="padding:10px;margin-bottom:10px;background-color:#efefef;word-wrap:break-word">
		<?php 
		$msg = str_replace("\n", "<br/>", $each->message);
		?>
		{{ $msg }} 
		<div style="clear:both"></div>
		
		<a href="{{ url('view',$each->user_owner->fid) }}">
		<div style="width:100%;border-top:1px solid #999;margin-top:5px;padding:5px">
		
		<div style="float:left">
		<img class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->user_owner->fid ; ?>/picture?type=square" >
		</div>
		
		<div class="block-name" style="width:50%"><?php echo $each->user_owner->username; ?></div>
		<div style="clear:both"></div>
		</div>
		</a>

		<div style="clear:both"></div>
		</div>
	@endforeach
</div>

@endsection