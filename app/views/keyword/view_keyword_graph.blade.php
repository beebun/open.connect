@section('content')

<div style="background-color:#0099cc;width:100%;margin-left:0px;margin-top:-9px;padding:5px">
	<div style="float:left"><img class="fb-pic" src="" style="height:100px;width:100px;border:3px solid #fff"></div>
	<div style="float:left;margin-left:10px;color:#fff;">
		<h3 style="line-height:30px"><span style="color:#333">Keyword</span><br/><?php echo $keyword ; ?></h3>
	</div>
	<div style="float:right">
		<a href="<?php echo url('/keyword/graph/'.$keyword.''); ?>" class="btn btn-info" style="margin-top:25px;margin-right:20px;width:200px;height:50px;font-size:20px;padding:10px">View Graph</a></div>
	<div style="clear:both"></div>
</div>

<div style="background-color:#e0e0e0;width:100%;margin-left:0px;padding:15px">
<?php for($i=0;$i<count($keyword_list);$i++):?>
	<?php if(!$remove[$i]): ?>
		<a href="" class="btn btn-primary" style="margin-right:5px;margin-top:5px"><?php echo $keyword_list[$i]->name; ?> - <?php echo $frequency[$i] ; ?></a>
	<?php endif ?>
<?php endfor ?>





<div style="background-color:#fff;width:100%;height:800px;border:1px solid #eee" id="data"></div>
<div style="clear:both"></div>
<script type="text/javascript" charset="utf-8">
	var w = 1200, h = 800;

	var labelDistance = 0;

	var vis = d3.select("#data").append("svg:svg").attr("width", w).attr("height", h);
	// var vis = document.getElementsById("data");

	var nodes = [];
	var labelAnchors = [];
	var labelAnchorLinks = [];
	var links = [];


	for(var i = 0; i < 20; i++) {
		var node = {
			label : "Node " + i
		};
		nodes.push(node);
		labelAnchors.push({
			node : node
		});
		labelAnchors.push({
			node : node
		});
	};

	for(var i = 1; i < nodes.length; i++) {
		links.push({
			source : 0,
			target : i,
			weight : Math.random()
		});
		labelAnchorLinks.push({
			source : i * 2,
			target : i * 2 + 1,
			weight : 100
		});
	};

	var force = d3.layout.force().size([w, h]).nodes(nodes).links(links).gravity(1).linkDistance(50).charge(-3000).linkStrength(function(x) {
		return x.weight * 10
	});


	force.start();

	var force2 = d3.layout.force().nodes(labelAnchors).links(labelAnchorLinks).gravity(0).linkDistance(0).linkStrength(8).charge(-100).size([w, h]);
	force2.start();

	var link = vis.selectAll("line.link").data(links).enter().append("svg:line").attr("class", "link").style("stroke", "red");

	var node = vis.selectAll("g.node").data(force.nodes()).enter().append("svg:g").attr("class", "node");

	node.append("svg:circle").attr("r", 5).style("fill", "#0099cc").style("stroke", "#FFF").style("stroke-width", 3).style("padding","10px");
	
	node.call(force.drag);

	var anchorLink = vis.selectAll("line.anchorLink").data(labelAnchorLinks)//.enter().append("svg:line").attr("class", "anchorLink").style("stroke", "#999");
	
	var anchorNode = vis.selectAll("g.anchorNode").data(force2.nodes()).enter().append("svg:g").attr("class", "anchorNode");
	
	anchorNode.append("svg:circle").attr("r", 0).style("fill", "#FFF");
	anchorNode.append("svg:text").text(function(d, i) {
		if(i == 0) return d.node.label 
		return i % 2 == 0 ? "" : d.node.label
	}).style("fill", "#555").style("font-family", "Arial").style("font-size", 20).style("font-weight","bold");

	var updateLink = function() {
		this.attr("x1", function(d) {
			return d.source.x;
		}).attr("y1", function(d) {
			return d.source.y;
		}).attr("x2", function(d) {
			return d.target.x;
		}).attr("y2", function(d) {
			return d.target.y;
		});

	}

	var updateNode = function() {
		this.attr("transform", function(d) {
			return "translate(" + d.x + "," + d.y + ")";
		});

	}

	force.on("tick", function() {

		force2.start();

		node.call(updateNode);

		anchorNode.each(function(d, i) {
			if(i % 2 == 0) {
				d.x = d.node.x;
				d.y = d.node.y;
			} else {
				var b = this.childNodes[1].getBBox();

				var diffX = d.x - d.node.x;
				var diffY = d.y - d.node.y;

				var dist = Math.sqrt(diffX * diffX + diffY * diffY);

				var shiftX = b.width * (diffX - dist) / (dist * 2);
				shiftX = Math.max(-b.width, Math.min(0, shiftX));
				var shiftY = 5;
				this.childNodes[1].setAttribute("transform", "translate(" + shiftX + "," + shiftY + ")");
			}
		});

		anchorNode.call(updateNode);

		link.call(updateLink);
		anchorLink.call(updateLink);

	});

</script>


@endsection