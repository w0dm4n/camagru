var debug = false;
	////////////////////////////        FUNCTION         //////////////////////////////
	function cheeze(canvas, img, context, x, y, height, width)
	{
		console.log("scroll top :" + document.body.scrollTop);
		context.drawImage(img, x, y, height, width);
		var dataURL = canvas.toDataURL("img/png").replace("data:image/png;base64,","");
		//console.log(dataURL);
	}
	////////////////////////////         MAIN            //////////////////////////////
	window.addEventListener("DOMContentLoaded", function()
	{
		// Grab elements, create settings, etc.
		var canvas = document.getElementById("canvas"),
			context = canvas.getContext("2d"),
			video = document.getElementById("video"),
			videoObj = { "video": true },
			errBack = function(error)
			{
				console.log("Video capture error: ", error.code); 
			};
		//constants
		document.getElementById("utils").action = 0;
		var mouse_double_clic = false;
		var x_mg = 0;
		var y_mg = 0;
		////////////
		///////////////////////            EVENT                 /////////////////////
		document.getElementById("snap").addEventListener("click", function()
		{
			cheeze(canvas, video, context, 0, 0, document.getElementById("video").width, document.getElementById("video").height);
		});
		document.getElementById("canvas").addEventListener("click", function()
		{
			if (document.getElementById("utils").action == 1)
			{
				cheeze(canvas, document.getElementById("utils"), context, (x_mg - canvas.getBoundingClientRect().left) - (document.getElementById("utils").width / 2), ((y_mg - canvas.getBoundingClientRect().top) -  document.body.scrollTop) - (document.getElementById("utils").height / 2), document.getElementById("utils").height, document.getElementById("utils").width);
				if (debug == true)
				{
					console.log("Objectadd{ posX: " + ((x_mg - canvas.getBoundingClientRect().left) - (document.getElementById("utils").width / 2)) + " posY: " + ((y_mg - canvas.getBoundingClientRect().top) - (document.getElementById("utils").height / 2)) + "}");
					console.log("left: " + canvas.getBoundingClientRect().left + "top: " + canvas.getBoundingClientRect().top);
				}
			}
		});
		document.getElementById("utils").addEventListener("click", function()
		{
			if (document.getElementById("utils").action == 0)
				document.getElementById("utils").action = 1;
			else
			{
				document.getElementById("utils").action = 0;
			}
		});
		document.getElementById("video").addEventListener("click", function()
		{
			cheeze(canvas, video, context, 0, 0, document.getElementById("video").width, document.getElementById("video").height);
		});
		///////////////////////////////////////////////////////////////////////////////
		////////////////////////////      CAMERA         //////////////////////////////
		if(navigator.getUserMedia)
		{ // Standard navigator
			navigator.getUserMedia(videoObj, function(stream)
			{
				video.src = stream;
				video.play();
			}, errBack);
		}
		else if(navigator.webkitGetUserMedia)
		{ // WebKit-prefixed
			navigator.webkitGetUserMedia(videoObj, function(stream)
			{
				video.src = window.webkitURL.createObjectURL(stream);
				video.play();
			}, errBack);
		}
		else if(navigator.mozGetUserMedia)
		{ // Firefox-prefixed
			navigator.mozGetUserMedia(videoObj, function(stream)
			{
				video.src = window.URL.createObjectURL(stream);
				video.play();
			}, errBack);
		}
		else if(navigator.msGetUserMedia)
		{ // IE I GUESS
			navigator.msGetUserMedia(videoObj, function(stream)
			{
				video.src = window.URL.createObjectURL(stream);
				video.play();
			}, errBack);
		}
		/////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////     timer example        //////////////////////
		/*function finish_double_clic()
		{
			mouse_double_clic = false;
		}
		document.onmousedown = downmouse;
		function downmouse(evenement)
		{
			if (mouse_double_clic == true)
			{
				console.log("doubleclic");
				var nbr = document.getElementById("utils").src.split("/");
				var nbr = nbr[6].split(".")[0];
				nbr++;
				document.getElementById("utils").src = "./img/utils/" + nbr + ".png";
				mouse_double_clic = false;
				return ;
			}
			var x =  evenement.pageX;
			var y =  evenement.pageY;
			console.log("x :" + x + " y :" + y);
			mouse_double_clic = true;
			setTimeout(finish_double_clic, 150);
		}*/
		//////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////        KEY EVENT       ////////////////////////////
		document.onkeydown = down;
		function down(evenement)
		{
			var key = evenement.keyCode;
			if (key == 13)
			{
				cheeze(canvas, video, context, 0, 0, document.getElementById("video").width, document.getElementById("video").height);
			}
			console.log(key);
		}
		document.onmousemove = move;
		function move(evenement)
		{
			if(navigator.appName=="Microsoft Internet Explorer")
			{
				var x = event.x+document.body.scrollLeft;
				var y = event.y+document.body.scrollTop;
			}
			else
			{
				var x =  evenement.pageX;
				var y =  evenement.pageY;
			}
			if (document.getElementById("utils").action == 1)
			{
				x_mg = x;
				y_mg = y;
			}
		}
		/////////////////////////////////////////////////////////////////////////////////////
	}, false);
