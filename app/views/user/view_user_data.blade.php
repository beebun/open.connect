@section('content')


<?php foreach($tag_list as $each): ?>
	<?php echo $each->name."<br/><br/>" ; ?>
<?php endforeach ?>

@endsection