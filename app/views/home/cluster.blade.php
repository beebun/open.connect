@section('content')

@foreach($cluster as $each_cluster)
	@foreach($each_cluster as $each_post)
		{{ $each_post->message }}<br/>
	@endforeach
	<hr>
@endforeach

@endsection