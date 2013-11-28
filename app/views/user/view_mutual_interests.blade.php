@section('content')

<div class="body">
<?php 
foreach($list1 as $each){
	echo $each->name."<br/>";
}

foreach($list2 as $each){
	echo $each->name."<br/>";
}
?>
	
</div>

@endsection