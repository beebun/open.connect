@section('content')


<div style="padding:10px;background-color:#fff;width:100%;margin-bottom:10px;position:fixed">
	<div class="body"> 
		<span style="color:#999;font-weight:bold">Statistic</span><br/>
		<!-- <input type="text" id="search-inp" class="form-control" style="width:200px;border-radius:0px" placeholder="Filter Name"> -->
		<span style="font-size:20px;font-weight:bold"><?php echo count($user_list); ?> total users</span>
		<div style="float:right;margin-top:-20px;margin-right:20px">
		<a href="#" onclick="get_mutual_interests();" class="btn btn-primary btn-large">View Mutual Interests</a></div>
		<div style="padding:5px;float:right;margin-top:-20px;margin-right:10px;width:300px;min-height:33px;background-color:#efefef">
			<div id="no-added-user" style="font-weight:bold;color:#999;width:100%;text-align:center">no added user</div>
			<div id="mutual_list"></div>
			<a href="#" onclick="clear_list();" id="clear-btn" style="display:none" class="btn btn-primary btn-xs">Clear</a>
		</div>
		<div style="float:right;margin-top:-20px;margin-right:10px">
			<input type="text" id="search-inp"  autocomplete="off" class="form-control" style="width:200px;border-radius:0px" placeholder="Filter Name">
		</div>
		<div style="clear:both"></div>
	</div>
</div>

<div class="body">
<br/><br/><br/><br/>
<?php foreach($user_list as $each): ?>
	<a href="<?php echo url('view',$each->fid); ?>" class="row1">

	<div class="block" id="<?php echo $each->fid ; ?>" rel="block-<?php echo $each->id ; ?>">
		<div class="block-img"><img class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->fid ; ?>/picture?type=square" ></div>
		<div id="ref-img-<?php echo $each->id ; ?>" style="display:none">
			<div style="float:left;width:40px;margin-right:3px">
				<img style="width:40px" class="fb-pic border" src="http://graph.facebook.com/<?php echo $each->fid ; ?>/picture?type=square" ><br/>
				<!-- <a href="#" onclick="clear_list();" class="btn btn-primary btn-xs" style="width:30px;padding:3px;float;right">Clear</a> -->
			</div>
		</div>
		<div class="block-name">
			<?php echo $each->username; ?>
		</div>
	</div>


	</a>
		<div id="block-<?php echo $each->id ; ?>" class="widget-container" style="display:none;float:left;margin-left:-72px;margin-top:38px">
			<a href="#" onclick="add_to_list(<?php echo $each->id ?>);" class="btn btn-success btn-xs">Add to list</a>
    	</div>

<?php endforeach ?>
</div>





<script type="text/javascript">

var mutual_list = 0;
var user_id = Array();

function get_mutual_interests(){
	if(mutual_list < 2) {
		bootbox.alert("<span class='alert'>You have to select at least 2 users</span>", function() {});
		return false;
	}
	var user1 = user_id[0];
	var user2 = user_id[1];
	window.location.href = '<?php echo url("/mutual_interests"); ?>/'+user1+'/'+user2;
}

function add_to_list(id){

	if ( !isExists(id) ){
		if(mutual_list == 0){
			$('#no-added-user').hide();
			$('#clear-btn').show();
		}
		var data = $('#ref-img-'+id).html();
		// $('#mutual_list').fadeOut("slow").hide();
		$('#mutual_list').append(data).fadeIn("slow");
		user_id.push(id);
		mutual_list++;
	}
}

function clear_list(){
	mutual_list = 0 ;
	user_id = Array();
	$('#clear-btn').hide();
	$('#no-added-user').show();
	$("#mutual_list").html("");
}

function isExists(id){
    return ($.inArray(id, user_id) > -1);
}

$( document ).ready(function() {


	$('.block').mouseover(function() {
	   var $this = $(this);
	   var id = $this.attr('rel');
	   var $currentWidget = $('#' + id);
	   $currentWidget.show().siblings('.widget-container').hide();
	});
	$('.body').mouseleave(function() {
	    $('.widget-container').hide();
	});
});



 $( document ).on( "keyup", "#search-inp", function() {
 		var searchTerm = $(this).val();
	    $(".row1").hide().filter(function() {
	        return $(this).text().indexOf(searchTerm) >= 0;
	    }).show();
	    return false ;
  });

</script>

@endsection