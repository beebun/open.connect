@section('content')


<div style="padding:10px;background-color:#fff;width:100%;margin-bottom:10px;">
	<div class="body"> 
		<span style="color:#999;font-weight:bold">Statistic</span><br/>
		<span style="font-size:20px;font-weight:bold"><?php echo count($user_list); ?> total users</span>
		<div style="float:right;margin-top:-20px;margin-right:20px"><a href="<?php echo url('/mutual_interests'); ?>" class="btn btn-primary btn-large">View Mutual Interests</a></div>
		<div style="clear:both"></div>
	</div>
</div>

<div style="clear:both"></div>

<div class="body">
<?php foreach($user_list as $each): ?>
	<a href="<?php echo url('view',$each->fid); ?>">
	<!-- 	<div class="menu" id="sub-menu-<?php echo $each->fid ; ?>" >
			<a href="" class="btn btn-primary">Add to list</a>
    	</div> -->
	<!-- <div class="block" id="<?php echo $each->fid ; ?>"></div> -->
	<div class="block" id="<?php echo $each->fid ; ?>">
		<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->fid ; ?>/picture?type=square" ></div>
		<div class="block-name">
			<?php echo $each->username; ?>
		</div>
	</div>
	</a>


<?php endforeach ?>
</div>





<script type="text/javascript">
$( document ).ready(function() {
	$(".menu").hide();


	$(".block").mouseover(function () {
		$('#sub-menu-'+this.id).slideDown('fast');
    	// $(".menu").slideDown('slow');
	});

	$(".block").mouseleave(function () {
	    // $(".menu").slideUp('slow');
	    $('#sub-menu-'+this.id).slideUp('fast');
	});

});

	// $.each($('.block'), function() {
	// 	$("#"+this.id).html("<span class='loading'>loading...</span>");
	// 	$("#"+this.id).load("get_user_data/"+this.id);
	// });
</script>

@endsection