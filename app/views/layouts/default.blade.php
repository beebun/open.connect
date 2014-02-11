<html>
<head>
<link href="<?php echo asset('css/bootstrap.css'); ?>" rel="stylesheet">    
    

<script src="<?php echo asset('js/angular/angular.js'); ?>"></script>
<script src="<?php echo asset('js/angular/facebook.js'); ?>"></script>

<script src="<?php echo asset('js/angular/import_data.js'); ?>"></script>
<script src="<?php echo asset('js/jquery-1.10.2.min.js'); ?>"></script>
<script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('js/d3.v2.js'); ?>"></script>
<script src="<?php echo asset('js/grid.js'); ?>"></script>
<script src="<?php echo asset('js/bootbox.js'); ?>"></script>
<script src="<?php echo asset('js/jedit.js'); ?>"></script>
<script src="<?php echo asset('js/imgLiquid.js'); ?>"></script>
</head>
    <body>

    <style>
    body{
    	background-color: #dfdfdf;
    	font-size: 13px;
    	color: #333;
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
    }
    .container1{
    	/*padding:10px;*/
    	width:100%;
    	margin:0px auto;
    	margin-top:50px;
    }

    #header{
    	width:100%;
    	margin-left: 0px;
    	margin-right: 0px;
    }
    .block{
    	padding:5px;
    	padding-top:3px;
    	width:200px;
    	float:left;
    	height: 60px;
    	background-color: #f0f0f0;
    	margin-right: 5px;
    	margin-bottom:5px;
    	color:#333;
    	/*border: 1px solid #d0d0d0;*/
        box-shadow: 1px 1px 1px 0px #d0d0d0;
    }
     .block-flat{
        padding:5px;
        padding-top:3px;
        width:200px;
        float:left;
        height: 60px;
        background-color: #f5f5f5;
        margin-right: 5px;
        margin-bottom:5px;
        color:#333;
        /*border: 1px solid #d0d0d0;*/
    }
    .block:hover{
    	background-color: #fff;
    }
    .block-name{
    	width:100px;
    	float:left;
    	margin-left:5px;
    	font-weight: bold;
    }
    .block-img{
    	width:50px;
    	float:left;
    }

    .form-control{
    	width:200px;
    }

    .border{
    	border: 1px solid #d0d0d0;
    }
    .loading{
    	color: #666;
    	font-weight: bold;
    }
    .alert{
        font-size: 20px;
        /*color: red;*/
    }
    .keyword-block{
    	color: #333;
    	text-align: center;
    	width:200px;
    	height: 50px;
    	padding:10px;
    	margin-right: 5px;
    	margin-bottom: 5px;
    	float:left;
    	background-color: #f0f0f0;
    	font-size: 14px;
    	font-weight: bold;
    	/*border: 1px solid #d0d0d0;*/
        box-shadow: 1px 1px 1px 0px #d0d0d0;
    }
    .keyword-block:hover{
    	background-color: #fff;
    }
    .keyword-block-rank{
    	margin-top:-5px;
    	float:left;
    	padding:10px;
    	color:#e0e0e0;
    	background-color: #333;
    	width:50px;
    }


    .btn{
        border-radius: 0px;
        /*background-color:#666;*/
        /*border-color:#666;*/
    }
    .btn:hover{
        border-radius: 0px;
        /*background-color:#333;*/
        /*border-color:#333;*/
    }
    .btn-large{
        /*width:200px;*/
        height:50px;font-size:20px;padding:10px;
    }
    .body{
        width:1025px;margin:0px auto;
    }

    .mutual-block{
        box-shadow: 1px 1px 1px 0px #d0d0d0;
        width:200px;
        padding:10px;
        height:100px;
        background-color:#efefef;
        float:left;margin-right:5px;
        margin-bottom:5px
    }
    .mutual-block:hover{
        background-color: #fff;
    }
    .message{
        background-color: #efefef;
        padding:10px;
        margin-top:0px;
        margin-bottom: 3px;
        box-shadow: 1px 1px 1px 0px #d0d0d0;
    }
    .active{
        font-weight: bold;
    }
    .head1{
        font-size: 30px;
    }

     .facebook-btn{
        -moz-user-select: none;
        background: #2A49A5;
        border: 1px solid #082783;
        box-shadow: 0 1px #4C6BC7 inset;
        color: white;
        padding: 13px;
        text-decoration: none;
        text-shadow: 0 -1px 0 #082783;
        font: 18px Helvetica;
        width:300px;
        height:50px;
        text-align:center;
        margin:0px auto;
    }

    .empty{
        color:#333;
        font-weight: bold;
    }
    
    </style>
    <?php 
    $segment = Request::segment(1);
    // if($segment == "keyword")
    // die();
    ?>
		<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
		  <div style="width:1055px;margin:0px auto;">
          <div class="navbar-header">
		    <a class="navbar-brand" href="<?php echo url('/'); ?>">Open.Connect</a>
		  </div>
		  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if(Auth::user()): ?>
            <ul class="nav navbar-nav">
		      <li <?php if($segment == "") echo 'class="active"' ; ?> ><a href="<?php echo url('/'); ?>">Home</a></li>
		      <li <?php if($segment == "user") echo 'class="active"' ; ?>><a href="<?php echo url('/user'); ?>">User</a></li>
		      <li <?php if($segment == "keyword") echo 'class="active"' ; ?>><a href="<?php echo url('/keyword'); ?>">Keyword</a></li>
            <li <?php if($segment == "group") echo 'class="active"' ; ?>><a href="<?php echo url('/group'); ?>">Group</a></li>

              <li <?php if($segment == "me") echo 'class="active"' ; ?>><a href="<?php echo url('/me'); ?>">Me</a></li>
		    </ul>
            <?php endif ?>

            <div class="nav navbar-nav navbar-right" style="color:#e0e0e0;margin-right:10px" id="user-block">
                <?php if(Auth::user()): ?>
                    <?php $data = Auth::user();?>
                    <?php $data['photo'] = str_replace("large", "square", $data['photo']) ; ?>
                    <div style="float:left"><img src="{{ $data['photo']}}" style="border:1px solid #fff;width:40px;margin-top:5px"></div>
                    <div style="float:left;font-weight:normal;margin-left:5px;margin-top:2px">
                    <?php echo $data['name']; ?>
                    <br/> <a href="<?php echo url('sign_out'); ?>" class="btn btn-danger btn-xs" style="border-radius:0px;font-weight:normal">Sign out</a></div>
                    <!-- <br/> <a href="#" onclick="FB_Logout();" class="btn btn-danger btn-xs" style="border-radius:0px;font-weight:normal">Sign out</a></div> -->
                    <div style="clear:both"></div>
                <?php else:?>
                    <!-- <a href="#" onclick="Login();" style="margin-top:7px" class="btn btn-primary facebook-btn-mini">Sign in with Facebook</a> -->
                <?php endif ?>
            </div>

		  </div>
          </div>
		</nav>

        <div class="container1" data-ng-app="OpenConnect">
                @if(Session::has('message'))
                    <div class="message" id="msg"><span style="font-weight:bold">Message</span> {{ Session::get('message')}}<div style="float:right"><a href="javascript:close_msg()">X</a></div></div>
                @endif
                @yield('content')
        </div>
    </body>
</html>




<script src="<?php echo asset('js/facebook.js'); ?>"></script>


<script type="text/javascript">
    $(".container1").gridalicious({
  animate: true,
  animationOptions: {
    queue: true,
    speed: 200,
    duration: 300,
    effect: 'fadeInOnAppear',
  }
});

    function close_msg(){
        $('#msg').hide(); 
    }
</script>

