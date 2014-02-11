@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script src="<?php echo asset('js/springy.js'); ?>"></script>
<script src="<?php echo asset('js/springyui.js'); ?>"></script>

<div style="background-color:#fff;width:100%;margin-left:0px;;padding:5px;box-shadow: 1px 1px 1px 0px #d0d0d0;">
	<div style="width:1025px;margin:0px auto;">

	<!-- <div style="float:left"> -->
	<!-- <img class="fb-pic" src="" style="height:100px;width:100px;border:3px solid #fff"></div> -->
		<div style="float:left;margin-left:10px;color:#333;margin-top:-10px">
			<h3 style="line-height:30px"><?php echo $keyword ; ?></h3>
			<div style="font-size:15px;"><?php echo $total_keyword; ?> related keywords</div>
		</div>
		<div style="float:right">
			<a href="<?php echo url('/keyword/'.$keyword.''); ?>" class="btn btn-info" style="margin-top:25px;margin-right:20px;width:200px;height:50px;font-size:20px;padding:10px">View Statistics</a></div>
		<div style="clear:both"></div>
	</div>
</div>


<div style="width:1025px;margin:0px auto;">

<div style="background-color:#e0e0e0;width:100%;margin-left:-5px;padding:10px;">

<?php $keyword_list = json_decode($keyword_list) ; ?>
<?php if(false): ?>
	<?php for($i=0;$i<count($keyword_list);$i++):?>
		<a href="" class="btn btn-primary" style="margin-right:5px;margin-top:5px"><?php echo $keyword_list[$i]->name; ?> - <?php echo $keyword_list->frequency[$i] ; ?></a>
	<?php endfor ?>
<?php endif ?>

<?php $data = json_encode($keyword_list); ?>

<script>
var data = '<?php echo $data ; ?>';
var keyword_name = '<?php echo $keyword ; ?>';
var graph = new Springy.Graph();
var color_value = "#0099cc";
// var dennis = graph.newNode({
//   label: 'Dennis',
//   ondoubleclick: function() { console.log("Hello!"); }
// });

var myObject = JSON.parse(data);
var node = new Array();
var center_node = graph.newNode({label: keyword_name});

for (var i in myObject) {
    var temp = myObject[i];
    node[i] = graph.newNode({label: temp.name});
}


for(var i=0;i<node.length;i++){
	graph.newEdge(center_node, node[i], {color: color_value});
}	



jQuery(function(){
  var springy = window.springy = jQuery('#springydemo').springy({
    graph: graph,
    nodeSelected: function(node){
     	console.log('Node selected: ' + JSON.stringify(node.data));
    }
  });

});
</script>
<canvas style="background-color:#fff;box-shadow: 1px 1px 1px 0px #999;" width="1025" height="600" id="springydemo"></canvas>

</div>
</div>

@endsection