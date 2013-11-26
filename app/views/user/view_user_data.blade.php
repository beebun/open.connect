@section('content')
<div style="background-color:#0099cc;width:100%;margin-left:0px;margin-top:-9px;padding:5px">
	<div style="float:left"><img class="fb-pic" src="http://graph.facebook.com/<?php echo $fid ; ?>/picture?type=large" style="height:100px;border:3px solid #fff"></div>
	<div style="float:left;margin-left:10px;color:#fff">
		<h3 style="line-height:30px"><span style="color:#333">User</span><br/><?php echo $user_data[0]->username ; ?></h3>
	</div>
	<div style="float:right">
		<a href="">
			<img src="http://www.underconsideration.com/brandnew/archives/facebook_logo_detail.gif" style="width:70px;margin-top:12px;margin-right:20px">
		</a>
	</div>
	<div style="clear:both"></div>
</div>

<div style="background-color:#e0e0e0;width:100%;margin-left:0px;padding:15px">
<?php $i=0; ?>
<?php foreach($tag_list as $each): ?>
	<?php if(!$remove[$i]):?>
		<?php echo $each->name." ".$frequency[$i]."<br/><br/>" ; ?>
	<?php endif ?>
	<?php $i++ ;?>
<?php endforeach ?>
</div>

@endsection