<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Proyect Pensum</title>
	<style>
		body {
			background-color: #333;
		}

		.star {
			width: 2px;
			height: 2px;
			border-radius: 2px;
			background: rgba(255,255,255,1);
			box-shadow: 0px 0px 1px 1px rgba(255,255,255,0.6);
			position: absolute;
		}
		#moon{
			position:absolute;
			top:15%;
			right:50%;
			right:calc(50% - 100px);
			width:200px;
			height:200px;
			border-radius:50%;
			background:#CCC;
			box-shadow:0px 0px 100px #FFFF8C;
			z-index:5;
			-webkit-animation: moonAnimation 3s infinite;
			-moz-animation: moonAnimation 3s infinite;
			animation: moonAnimation 3s infinite;
		}

		#moonFase{
			position:absolute;
			top:15%;
			right:50%;
			right:calc(50% - 100px);
			width:200px;
			height:200px;
			border-radius:50%;
			background: rgba(153,153,153,0);
			box-shadow: inset -25px 0px 0 0px #999;
			z-index:6;
			-webkit-animation: moonFaseAnimation 600s infinite;
			-moz-animation: moonFaseAnimation 600s infinite;
			animation: moonFaseAnimation 600s infinite;
		}

		.crater{
			position:absolute;
			background:#555;
			box-shadow: inset 3px -2px 0 0px #414043;
			z-index:7;
		}

		.crater1{
			top:30px;
			left:40px;
			width:25px;
			height:45px;
			border-top-right-radius:50px 100px;
			border-top-left-radius:50px 100px;
			border-bottom-right-radius:50px 100px;
			border-bottom-left-radius:50px 100px;
			-webkit-transform:rotate(40deg);
			-moz-transform:rotate(40deg);
			transform:rotate(40deg);
		}

		.crater2{
			top:125px;
			right:20px;
			width:15px;
			height:20px;
			border-top-right-radius:20px 20px;
			border-top-left-radius:20px 20px;
			border-bottom-right-radius:20px 30px;
			border-bottom-left-radius:20px 30px;
			-webkit-transform:rotate(-60deg);
			-moz-transform:rotate(-60deg);
			transform:rotate(-60deg);
		}

		.crater3{
			top:120px;
			left:60px;
			width:10px;
			height:10px;
			border-radius:50%;
		}

		.crater4{
			top:90px;
			right:90px;
			width:10px;
			height:10px;
			border-radius:50%;
		}

		.crater5{
			top:50px;
			left:120px;
			width:30px;
			height:35px;
			border-radius:50%;
			-webkit-transform:rotate(120deg);
			-moz-transform:rotate(120deg);
			transform:rotate(120deg);
		}

		.crater6{
			bottom:15px;
			left:80px;
			width:15px;
			height:15px;
			border-radius:50%;
		}

		.crater7{
			bottom:15px;
			left:130px;
			width:5px;
			height:5px;
			border-radius:50%;
		}
		/*-----------------------------------*/
		@keyframes "moonFaseAnimation" {
			0% {
				box-shadow: inset -25px 0px 0 0px #999;
				background: rgba(153,153,153,0);
			}
			50% {
				box-shadow: inset -200px 0px 0 0px #999;
			}
			51% {
				background: rgba(153,153,153,1);
			}
			52% {
				box-shadow: inset 200px 0px 0 0px #999;
			}
			53% {
				background: rgba(153,153,153,0);
			}
			100% {
				box-shadow: inset -25px 0px 0 0px #999;
			}

		}

		@-moz-keyframes moonFaseAnimation {
			0% {
				box-shadow: inset -25px 0px 0 0px #999;
				background: rgba(153,153,153,0);
			}
			50% {
				box-shadow: inset -200px 0px 0 0px #999;
			}
			51% {
				background: rgba(153,153,153,1);
			}
			52% {
				box-shadow: inset 200px 0px 0 0px #999;
			}
			53% {
				background: rgba(153,153,153,0);
			}
			100% {
				box-shadow: inset -25px 0px 0 0px #999;
			}

		}

		@-webkit-keyframes "moonFaseAnimation" {
			0% {
				box-shadow: inset -25px 0px 0 0px #999;
				background: rgba(153,153,153,0);
			}
			50% {
				box-shadow: inset -200px 0px 0 0px #999;
				/* background: rgba(153,153,153,0);*/
			}
			51% {
				background: rgba(153,153,153,1);
			}
			52% {
				box-shadow: inset 200px 0px 0 0px #999;
			}
			53% {
				background: rgba(153,153,153,0);
			}
			100% {
				box-shadow: inset -25px 0px 0 0px #999;
			}

		}
		/*-----------------------------------*/
		@keyframes "moonAnimation" {
			0% {
				box-shadow: 0px 0px 100px #FFF;
			}
			50% {
				box-shadow: 0px 0px 140px #FFF;
			}
			100% {
				box-shadow: 0px 0px 100px #FFF;
			}

		}

		@-moz-keyframes moonAnimation {
			0% {
				box-shadow: 0px 0px 100px #FFF;
			}
			50% {
				box-shadow: 0px 0px 140px #FFF;
			}
			100% {
				box-shadow: 0px 0px 100px #FFF;
			}

		}

		@-webkit-keyframes "moonAnimation" {
			0% {
				box-shadow: 0px 0px 100px #FFF;
			}
			50% {
				box-shadow: 0px 0px 140px #FFF;
			}
			100% {
				box-shadow: 0px 0px 100px #FFF;
			}

		}
	</style>

</head>
<body>
<section class="example2">
	<div id="moon">
	</div>
	<div id="moonFase">
		<div class="crater crater1"></div>
		<div class="crater crater2"></div>
		<div class="crater crater3"></div>
		<div class="crater crater4"></div>
		<div class="crater crater5"></div>
		<div class="crater crater6"></div>
		<div class="crater crater7"></div>
	</div>
</section>
<script>

	// determino el tamano de la pantalla
	var w = window.innerWidth;
	var h = window.innerHeight;

	// pinto 250 estrellas random
	for (i = 0; i < 250; i++) {
		wRan = Math.floor(Math.random() * w);
		hRan = Math.floor(Math.random() * h);
		var star = document.createElement("div");
		star.setAttribute("class", "star");
		star.style.bottom = hRan + "px";
		star.style.right = wRan + "px";
		document.body.appendChild(star);
	}
</script>
</body>
</html>
