<html>
<head>
<link href="<?php echo asset('css/bootstrap.css'); ?>" rel="stylesheet">
<script src="<?php echo asset('js/jquery-1.10.2.min.js'); ?>"></script>
<script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('js/d3.v2.js'); ?>"></script>
<script src="<?php echo asset('js/grid.js'); ?>"></script>
<script src="<?php echo asset('js/bootbox.js'); ?>"></script>

</head>
    <body>

    <style>
    body{
    	background-color: #dfdfdf;
    	font-size: 13px;
    	color: #333;
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
        background-color:#666;
        border-color:#666;
    }
    .btn:hover{
        border-radius: 0px;
        background-color:#333;
        border-color:#333;
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
    </style>

		<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
		  <div style="width:1025px;margin:0px auto;">
          <div class="navbar-header">
		    <a class="navbar-brand" href="<?php echo url('/'); ?>">Open.Connect</a>
		  </div>
		  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    <ul class="nav navbar-nav">
		      <li class=""><a href="<?php echo url('/'); ?>">Home</a></li>
		      <li><a href="<?php echo url('/user'); ?>">User</a></li>
		      <li><a href="<?php echo url('/keyword'); ?>">Keyword</a></li>
            <li><a href="<?php echo url('/keyword'); ?>">Me</a></li>
		    </ul>
		  </div>
          </div>
		</nav>

        <div class="container1">
                @yield('content')
        </div>
    </body>
</html>


<script type="text/javascript">
    $(".container1").gridalicious({
  animate: true,
  animationOptions: {
    queue: true,
    speed: 200,
    duration: 300,
    effect: 'fadeInOnAppear',
    complete: onComplete
  }
});
</script>

