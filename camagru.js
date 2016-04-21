	//////////////////////////   constants     ///////////////////////////////////////
	var debug = false;
	var cursor_x = -1;
	var cursor_y = -1;
	var old_cursor_x = -1;
	var old_cursor_y = -1;
	var create = false;
	var back = new Image();
	var oldback = new Image();
	var img = new Image();
	var moveLoop;
	var action = false;
	var current_element = null;
	var obj_name = "object_0";
	///////////////////////////////////////////////////////////////////////////////////
	////////////////////////////        FUNCTION         //////////////////////////////
	function cheeze(canvas, img, context, x, y, height, width, save)
	{
		context.drawImage(img, x, y, height, width);
		if (save == true)
		{
			var dataURL = canvas.toDataURL("img/png").replace("data:image/png;base64,","");
			document.getElementById("background").value = dataURL;
			document.getElementById("texture").value = "";
		}
	}
	function dofile()
	{
		var canvas = document.getElementById("canvas");
		var context = canvas.getContext("2d");
		cheeze(canvas, document.getElementById("mega"), context, 0, 0, document.getElementById("mega").width, document.getElementById("mega").height, true);
		window.clearInterval(moveLoop);
		var element = document.getElementById("mega");
		element.parentNode.removeChild(element);
	}
	function loadFile(evenement)
	{
		if (event.target.files && event.target.files[0])
		{
			var new_mg=document.createElement("img");
			new_mg.setAttribute('id', 'mega');
			new_mg.setAttribute('action', '0');
			new_mg.setAttribute('src', URL.createObjectURL(event.target.files[0]));
			img = new Image();
	        img.src = URL.createObjectURL(event.target.files[0]);
	        if (event.target.files[0].size > 1655000 || event.target.files[0].type.indexOf("image") == -1)
	        	return ;
	        img.onload = function ()
	        {
	        	new_mg.setAttribute('height', 480);
				new_mg.setAttribute('width', 640);
				document.getElementById("canvas").height = 480;
				document.getElementById("canvas").width = 640;
	        };
			document.body.appendChild(new_mg);
			moveLoop = setInterval(dofile, 10);
		}
	}
	function domove()
	{
		var canvas = document.getElementById("canvas");
		var context = canvas.getContext("2d");
		back_old = back;
		if (((cursor_x - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2)) <= 0)
		{
			cursor_x = canvas.getBoundingClientRect().left + (document.getElementById(obj_name).width / 2);
		}
		context.putImageData(back_old, (old_cursor_x - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2), ((old_cursor_y - canvas.getBoundingClientRect().top) -  document.body.scrollTop) -  (document.getElementById(obj_name).height / 2));
		back = context.getImageData((cursor_x - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2), ((cursor_y - canvas.getBoundingClientRect().top) -  document.body.scrollTop) -  (document.getElementById(obj_name).height / 2), document.getElementById(obj_name).width, document.getElementById(obj_name).height);
		context.drawImage(document.getElementById(obj_name), (cursor_x - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2), ((cursor_y - canvas.getBoundingClientRect().top) -  document.body.scrollTop) -  (document.getElementById(obj_name).height / 2), document.getElementById(obj_name).width, document.getElementById(obj_name).height);
		old_cursor_x = cursor_x;
		old_cursor_y = cursor_y;
	}
	function draw_canvas(evenement)
	{
		var canvas = document.getElementById("canvas");
		var context = canvas.getContext("2d");
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
		if (obj_name != "object_0" && ((cursor_x - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2)) > 0)
		{
			if (action == true && create == false)
			{
				old_cursor_x = cursor_x;
				old_cursor_y = cursor_y;
				back = context.getImageData((cursor_x - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2), ((cursor_y - canvas.getBoundingClientRect().top) -  document.body.scrollTop) -  (document.getElementById(obj_name).height / 2), document.getElementById(obj_name).width, document.getElementById(obj_name).height);
				context.drawImage(document.getElementById(obj_name), cursor_x - canvas.getBoundingClientRect().left, cursor_y - canvas.getBoundingClientRect().top, document.getElementById(obj_name).width, document.getElementById(obj_name).height);
				create = true;
				moveLoop = setInterval(domove, 10);
			}
		}
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
				var element = document.getElementById("snap");
				element.parentNode.removeChild(element);
			};
		document.getElementById("import").type = "file";
		var mouse_double_clic = false;
		var x_mg = 0;
		var y_mg = 0;
		for (i = 1; i < 100; i++)
		{
			if (document.getElementById("object_" + i))
			{
				document.getElementById("object_" + i).addEventListener("click", function()
				{
					obj_name = this.id;
					create = false;
					action = true;
				});
			}
		}
		////////////
		///////////////////////            EVENT                 /////////////////////
		document.getElementById("snap").addEventListener("click", function()
		{
			cheeze(canvas, video, context, 0, 0, document.getElementById("video").width, document.getElementById("video").height, true);
		});
		document.getElementById("canvas").addEventListener("click", function()
		{
			if (obj_name != "object_0")
			{
				if (document.getElementById("texture").value == "")
					document.getElementById("texture").value += obj_name.split("_")[1] + "," + (cursor_y - canvas.getBoundingClientRect().top) + "," + (cursor_x - canvas.getBoundingClientRect().left);
				else
					document.getElementById("texture").value += ";" + obj_name.split("_")[1] + "," + cursor_y + "," + cursor_x;
				cheeze(canvas, document.getElementById(obj_name), context, (x_mg - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2), ((y_mg - canvas.getBoundingClientRect().top) -  document.body.scrollTop) - (document.getElementById(obj_name).height / 2), document.getElementById(obj_name).height, document.getElementById(obj_name).width, false);
				if (debug == true)
				{
					console.log("Objectadd{ posX: " + ((x_mg - canvas.getBoundingClientRect().left) - (document.getElementById(obj_name).width / 2)) + " posY: " + ((y_mg - canvas.getBoundingClientRect().top) - (document.getElementById(obj_name).height / 2)) + "}");
					console.log("left: " + canvas.getBoundingClientRect().left + "top: " + canvas.getBoundingClientRect().top);
				}
			}
		});
		if (document.getElementById("video"))
		document.getElementById("video").addEventListener("click", function()
		{
			cheeze(canvas, video, context, 0, 0, document.getElementById("video").width, document.getElementById("video").height, true);
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
		document.onmousedown = downmouse;
		function downmouse(evenement)
		{
			if (action == true)
				action = false;
			window.clearInterval(moveLoop);
		}
		/////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////        KEY EVENT       ////////////////////////////
		document.onkeydown = down;
		function down(evenement)
		{
			var key = evenement.keyCode;
			if (key == 13 || key == 32)
			{
				cheeze(canvas, video, context, 0, 0, document.getElementById("video").width, document.getElementById("video").height, true);
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
			cursor_x = x;
			cursor_y = y;
		}
		/////////////////////////////////////////////////////////////////////////////////////
	}, false);
/////////////////////////////////////////////////////////////////////////////////////////////