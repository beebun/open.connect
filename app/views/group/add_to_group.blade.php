@section('content')
<select id="group-id" class="form-control" style="width:200px;margin:0px auto">
@foreach($groups as $group)
<option value="{{ $group->id }}">{{ $group->name }}</option>
@endforeach
</select>
@endsection