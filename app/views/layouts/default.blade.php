<html>
<head>
<link href="<?php echo asset('css/bootstrap.min.css'); ?>" rel="stylesheet">
<script src="<?php echo asset('js/jquery-1.10.2.min.js'); ?>"></script>
<script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('js/d3.v2.js'); ?>"></script>

<!-- <div id="loadingDiv"><br/><br/>Loading....</div> -->
   <script type='text/javascript'>
        // $(window).load(function(){
        //     $(document).ready(function() {
        //         jQuery.ajaxSetup({
        //             beforeSend: function() {
        //                 $('#loadingDiv').show();
        //             },
        //             complete: function(){
        //                 $('#loadingDiv').hide();
        //             },
        //             success: function() {}
        //         });
        //     });
        // });
    </script>


</head>
    <body>

    <style>
    body{
    	background-color: #e0e0e0;
    	font-size: 13px;
    	color: #333;
    }
    .container1{
    	/*padding:10px;*/
    	width:100%;
    	margin:0px auto;
    	margin-top:60px;
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
    	border: 1px solid #d0d0d0;
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
    	border: 1px solid #d0d0d0;
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
    </style>

		<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
		  <div class="navbar-header">
		    <a class="navbar-brand" href="<?php echo url('/'); ?>">open-connect</a>
		  </div>
		  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    <ul class="nav navbar-nav">
		      <li class="active"><a href="<?php echo url('/'); ?>">Home</a></li>
		      <li><a href="<?php echo url('/user'); ?>">User</a></li>
		      <li><a href="<?php echo url('/keyword'); ?>">Keyword</a></li>
		      <li><a href="<?php echo url('/keyword'); ?>">Import Data</a></li>
		    </ul>
		  </div>
		</nav>
        <div class="container1">
            @yield('content')
        </div>
    </body>
</html>

