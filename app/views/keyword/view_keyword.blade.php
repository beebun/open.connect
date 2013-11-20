@section('content')
<?php foreach($tag_list as $each): ?>
	-<?php echo $each->post_id ; ?><br/>
<?php endforeach ?>
@endsection