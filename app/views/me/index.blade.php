@section('content')
<style type="text/css">
	.strong{
		font-weight: bold;
	}
	.muted{
		color: #999;
		font-size:15px;
	}
</style>

<div style="background-color:#fff;width:100%;padding:5px;box-shadow: 1px 1px 1px 0px #d0d0d0;">
	<div class="body">
	<span style="font-size:20px">My Profile</span>
	</div>
</div>

<div class="body" style="margin-top:10px">

<div style="font-size:15px;padding:10px;background-color:#efefef;width:240px;float:left;margin-rigth:10px">
	<div class="head1" style="border-bottom:1px solid #999;margin-bottom:10px">Statistics</div>
	<span>Total Tags</span>: <span class="strong"><?php echo $total_tag; ?></span><br/>
	<span>Total Posts</span>: <span class="strong"><?php echo $total_post; ?></span><br/>
	<span>Total Connected Users</span>: <span class="strong"><?php echo $total_connected_user; ?></span><br/>
</div>

<div style="float:left;width:780px;margin-left:5px;background-color:#efefef;padding:10px;font-size:18px;min-height:50%">
<div class="head1" style="border-bottom:1px solid #999;margin-bottom:10px">Value Configuration</div>
Minimum Frequency: <span class="strong value" id="minimum_frequency" name="minimum_frequency"><?php echo $minimum_support; ?></span> <span class="muted" id="edit_minimum_frequency" style="display:none">(click to edit)</span>
</div>

<div style="clear:both"></div>
</div>

<script type="text/javascript">
	$( ".value" ).hover(
	function() {
		$('#edit_'+this.id).show();
	}, function() {
		$('#edit_'+this.id).hide();
	}
	);


	 $('#minimum_frequency').editable('./edit_minimum_frequency', {
         type : 'text',
         name : 'minimum_frequency',
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         callback : function(value, settings) {
        }
     });

</script>
@endsection