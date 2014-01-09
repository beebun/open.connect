@section('content')
<div style="padding:10px;background-color:#fff;width:100%;float:left;margin-bottom:10px;position:fixed">
	<div class="body">
		<span style="color:#999;font-weight:bold">Statistic</span><br/>
		<span style="font-size:20px;font-weight:bold"><?php echo count($tag_list); ?> total keywords</span>
		<div style="float:right;margin-top:-20px;margin-right:10px">
			<input type="text" id="search-inp"  autocomplete="off" class="form-control" style="width:200px;border-radius:0px" placeholder="Filter Name">
		</div>
		<div style="float:right;margin-right:10px;margin-top:-20px">
			<?php if($is_view_removed): ?>
				<a href="<?php echo url('keyword/'); ?>" class="btn btn-primary">View Tags</a>
			<?php else:?>
				<a href="<?php echo url('keyword/remove'); ?>" class="btn btn-primary">View Removed Tags</a>
			<?php endif ?>
		</div>
		<div style="clear:both"></div>
	</div>
</div>
<div style="clear:both"></div>

<div class="body">
<br/><br/><br/><br/>
	<?php $i=0; ?>
	<?php foreach($tag_list as $each): ?>

		<a href="<?php echo url('keyword',$each->name); ?>" id="link-<?php echo $i ; ?>" class="row1">
			<input type="hidden" value="<?php echo $each->name; ?>" id="hidden-<?php echo $i; ?>">
			<div class="block keyword-block" id="<?php echo $i ;?>" rel="block-<?php echo $i ; ?>">
				<div class="keyword-block-rank"><?php echo $each->total ; ?></div>
				<?php echo $each->name ; ?>
			</div>
		</a>
		<?php if(!$is_view_removed): ?>
		<div id="block-<?php echo $i ; ?>" class="widget-container" style=";float:left;margin-left:-60px;margin-top:28px">
			<a href="javascript:remove_tag(<?php echo $i++; ?>);" class="btn btn-success btn-xs">Remove</a>
    	</div>
    	<?php else:?>
    	<div id="block-<?php echo $i ; ?>" class="widget-container" style=";float:left;margin-left:-39px;margin-top:28px">
			<a href="javascript:add_tag(<?php echo $i++; ?>);" class="btn btn-success btn-xs">Add</a>
    	</div>
    	<?php endif ?>
	<?php endforeach ?>
	<div style="clear:both"></div>
</div>

<script type="text/javascript">

	var is_removing = false ;


 $( document ).on( "keyup", "#search-inp", function() {
 		var searchTerm = $(this).val();
	    $(".row1").hide().filter(function() {
	        return $(this).text().indexOf(searchTerm) >= 0;
	    }).show();
	    return false ;
  });

	function remove_tag(id){
		var tag_name = $('#hidden-'+id).val();
		$.post( "<?php echo url('keyword/remove_tag'); ?>", 
        {name: tag_name})
        .done(function( data2 ) {

        	is_removing = true; 
			$('#'+id).fadeOut(500);
			is_removing = false ;
        }).error(function(data){

        });
	}

	function add_tag(id){
		var tag_name = $('#hidden-'+id).val();
		$.post( "<?php echo url('keyword/add_tag'); ?>", 
        {name: tag_name})
        .done(function( data2 ) {
        	is_removing = true; 
			$('#'+id).fadeOut(500);
			is_removing = false ;
        });
	}

	$( document ).ready(function() {
		$('.widget-container').hide();

		$('.block').mouseover(function() {
			if(!is_removing){
				var $this = $(this);
				var id = $this.attr('rel');
				var $currentWidget = $('#' + id);
				$currentWidget.show().siblings('.widget-container').hide();
			}
		});
		$('.body').mouseleave(function() {
		    $('.widget-container').hide();
		});
	});
</script>
@endsection