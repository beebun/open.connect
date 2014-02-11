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

<div class="body" style="margin-top:10px" data-ng-controller="MainController">

<div style="height:80%;font-size:15px;padding:10px;background-color:#efefef;width:240px;float:left;margin-rigth:10px">
	<div class="head2" style="margin-bottom:10px"><Strong>Statistics</Strong></div>
	<table class="table">
	<!-- <tr><td><span>Total Tags</span> <span class="strong pull-right">{{ $total_tag }}</span></td></tr> -->
	<tr><td><span>Total Posts</span> <span class="strong pull-right">{{ $total_post }}</span></td></tr>
	<tr><td><span>Total Connected Users</span> <span class="strong pull-right">{{ $total_connected_user }}</span></td></tr>
	<tr><td><span>Total Keyword</span> <span class="strong pull-right">{{ $total_keyword }}</span></td></tr>

	<tr><td><span>New Post</span> <span class="strong pull-right">{{ $not_processing_post }}</span></td></tr>
	</table>
</div>

<div style="float:left;width:780px;margin-left:5px;background-color:#efefef;padding:10px;font-size:18px;">
<div class="head2" style="border-bottom:1px solid #999;margin-bottom:10px"><strong>Value Configuration</strong></div>
Minimum Frequency: <span class="strong value" id="minimum_frequency" name="minimum_frequency"><?php echo $minimum_support; ?></span> <span class="muted" id="edit_minimum_frequency" style="display:none">(click to edit)</span>

<div style="clear:both"></div>
</div>

<div style="float:left;width:780px;margin-left:5px;background-color:#efefef;padding:10px;font-size:18px;margin-top:10px">
<div class="head2" style="margin-bottom:10px"><strong>1) Import Data</strong></div>


<div style="margin-top:10px;padding:10px;background-color:#fff">
	<div class="pull-left">
	<button type="button" class="btn btn-primary" data-ng-show="!logged" data-ng-disabled="!facebookReady" data-ng-click="IntentLogin()" style="width:200px"><strong>Import data</strong></button>
	<button type="button" style="width:200px" class="btn btn-danger" data-ng-show="logged" data-ng-disabled="!facebookReady" data-ng-click="stopImporting()"><strong>Stop importing data</strong></button>
	</div>

	<div ng-show="logged" class="pull-right" style="margin-top:10px">
		<img src="http://www.tribefit.com/App_Themes/Tribefit/Images/GeneralImages/loading.gif" style="margin-top:-20px;width:120px">
	</div>
	<div style="clear:both"></div>
</div>

<div style="clear:both"></div>
</div>




<div style="float:left;width:780px;margin-left:5px;background-color:#efefef;padding:10px;font-size:18px;margin-top:10px">
<div class="head2" style="margin-bottom:10px"><strong>2) Process Data</strong>
<span class="label label-danger pull-right"> {{ $not_processing_post }} posts to process</span></div>


<div style="margin-top:10px;padding:10px;background-color:#fff">
	<div class="pull-left">
	<button type="button" data-ng-click="generateKeyword()" data-ng-show="!isGeneratingKeyword" class="btn btn-primary" style="width:200px"><strong>Generate Keyword</strong></button>
	<button type="button" data-ng-click="stopImporting()" data-ng-show="isGeneratingKeyword" class="btn btn-danger" style="width:200px"><strong>Stop Generating Keyword</strong></button>

	</div>

	<div style="clear:both"></div>
</div>

<div style="clear:both"></div>
</div>


<div style="float:left;width:780px;margin-left:5px;background-color:#efefef;padding:10px;font-size:18px;margin-top:10px">
<div class="head2" style="margin-bottom:10px"><strong>3) Ranking</strong>
<span class="label label-danger pull-right"> {{ $not_processing_keyword }} keywords to process</span></div>


<div style="margin-top:10px;padding:10px;background-color:#fff">
	<div class="pull-left">
	<button type="button" data-ng-click="generateKeywordRank()" data-ng-show="!isGeneratingKeywordRank" class="btn btn-primary" style="width:200px"><strong>Ranking Keyword</strong></button>
	<button type="button" data-ng-click="stopImporting()" data-ng-show="isGeneratingKeywordRank" class="btn btn-danger" style="width:200px"><strong>Stop Ranking Keyword</strong></button>

	</div>

	<div style="clear:both"></div>
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

