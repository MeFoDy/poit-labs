function rand(min/* max */, max) {
    return Math.floor(arguments.length > 1 ? (max - min + 1) * Math.random() + min : (min + 1) * Math.random());
};

// POPUP
(function($) {
	$.fn.popup = function(color, msg) {
		if (color === "error")
			color = "#C00"
		else if (color === "success")
			color = "#060";
		$('<div></div>')
		.appendTo('body')
		.hide()
		.html("<p class='popup'>" + msg + " <a href='' id='close-popup'>+</a></p>")
		.css({
			"position":"fixed",
			"width":"99%",
			"background-color":color,
			"color":"white",
			"text-align":"center",
			"top":"0",
			"vertical-align":"central",
			"border-radius":"0 0 30px 30px"
		})
		.fadeIn("fast");
	};
})(jQuery);

// скроллинг к нужному элементу
function scroll_to_elem(elem,speed) {
	if(document.getElementById(elem)) {
		var destination = jQuery('#'+elem).offset().top;
		jQuery("html,body").animate({scrollTop: destination}, speed);
	}
}


//=========================================================================================

$(document).ready(function(e) {
			var posX = $('#canvas').offset().left;
			var posY = $('#canvas').offset().top;

// IE hack 
function ie_event(e)
{
	if (e === undefined)
		{ return window.event; };
	return e;
}

/***********************************************************************
 *                 Main Canva Object                                   *
 **********************************************************************/
var Canva = {};

Canva.init = function(id, width, height)
{
	var canv = document.getElementById(id);
	canv.width = width;
	canv.height = height;

	this.canvasId = id;
	
	this.ctx = canv.getContext("2d");
	
	this.selectedColor = '#000000';
	this.selectedFillColor = '#FFFFFF';
	this.selectedWidth = 1;
	
	this.tool = Wall;
	this.drawing = false;
	
	canv.onmousedown = function(e)
	{
		var evnt = ie_event(e);
		Canva.tool.start(evnt);
		Canva.clear();
		Canva.paintAll();
	};
	
	canv.onmouseup = function(e)
	{
		if (Canva.drawing)
		{
			var evnt = ie_event(e);
			Canva.tool.finish(evnt);
		}		
		Canva.paintAll();
	};
	
	canv.onmousemove = function(e)
	{
		if (Canva.drawing)
		{
			var evnt = ie_event(e);
			Canva.tool.move(evnt);
		}
		Canva.paintAll();
		document.getElementById(Canva.canvasId).style.cursor = 'crosshair';
	};
};

Canva.paintAll = function() {
		Door.paint(Door.x, Door.y);
		Wall.paint(Wall.x, Wall.y);
		Wind.paint(Wind.x, Wind.y);
		Tube.paint(Tube.x, Tube.y);
		Roof.paint(Roof.x, Roof.y);
};

Canva.setTool = function(t)
{
	Canva.tool = t;
};

Canva.setWidth = function(width)
{
	Canvas.selectedWidth = width;
};

Canva.setColor = function(color)
{
	Canva.selectedColor = color;
};

Canva.clear = function()
{
	var canv = document.getElementById(Canva.canvasId);
	Canva.ctx.clearRect(0, 0, canvas.width, canvas.height);
};
/**********************************************************************/

/**********************************************************************
 *                      Pencil                                        * 
 *********************************************************************/


var Pencil = {};

Pencil.start = function(evnt)
{
	Pencil.x = evnt.pageX - posX;
	Pencil.y = evnt.pageY - posY;
	
	Canva.ctx.beginPath();
	Canva.ctx.strokeStyle = Canva.selectedColor;
    Canva.ctx.lineWidth = Canva.selectedWidth;
    Canva.ctx.moveTo(Pencil.x, Pencil.y);
    
    Canva.drawing = true;
};

Pencil.finish = function(evnt)
{	
	Pencil.x = evnt.pageX - posX;
	Pencil.y = evnt.pageY - posY;
	Canva.ctx.lineTo(Pencil.x, Pencil.y);
		
	Canva.drawing = false;
};

Pencil.move = function(evnt)
{	
	Pencil.x = evnt.pageX - posX;
	Pencil.y = evnt.pageY - posY;
	Canva.ctx.lineTo(Pencil.x, Pencil.y);
	Canva.ctx.stroke();
	Canva.ctx.moveTo(Pencil.x, Pencil.y);
};
/**********************************************************************/
/**********************************************************************
 *                      Wall                                          * 
 *********************************************************************/
var Wall = {};
Wall.x = -1000;
Wall.y = -1000;

Wall.start = function(evnt)
{
	//Canva.clear();
	Wall.x = evnt.pageX - posX;
	Wall.y = evnt.pageY - posY;
	
	Wall.paint(Wall.x, Wall.y);
    
    Canva.drawing = true;
};

Wall.finish = function(evnt)
{	
	Wall.x = evnt.pageX - posX;
	Wall.y = evnt.pageY - posY;
		
	Canva.drawing = false;
};

Wall.paint = function(x,y) {
	Canva.ctx.beginPath();
	Canva.ctx.strokeStyle = 'black';
    Canva.ctx.lineWidth = 3;
    Canva.ctx.rect(x-150, y-75, 300, 150);
	Canva.ctx.stroke();
};

Wall.move = function(evnt)
{	
	Wall.x = evnt.pageX - posX;
	Wall.y = evnt.pageY - posY;
	Canva.clear();
	Wall.paint(Wall.x, Wall.y);
};
/**********************************************************************/
/**********************************************************************
 *                      Wind                                          * 
 *********************************************************************/
var Wind = {};
Wind.x = -1000;
Wind.y = -1000;

Wind.start = function(evnt)
{
	//Canva.clear();
	Wind.x = evnt.pageX - posX;
	Wind.y = evnt.pageY - posY;
    
	Wind.paint(Wind.x, Wind.y);
    Canva.drawing = true;
};

Wind.paint = function(x,y) {
	Canva.ctx.beginPath();
	Canva.ctx.strokeStyle = 'black';
    Canva.ctx.lineWidth = 3;
    Canva.ctx.rect(x-50, y-25, 100, 50);
	Canva.ctx.moveTo(x,y-25);
	Canva.ctx.lineTo(x, y+25);
	Canva.ctx.stroke();
};

Wind.finish = function(evnt)
{	
	Wind.x = evnt.pageX - posX;
	Wind.y = evnt.pageY - posY;
		
	Canva.drawing = false;
};

Wind.move = function(evnt)
{	
	Wind.x = evnt.pageX - posX;
	Wind.y = evnt.pageY - posY;
	Canva.clear();
	
	Wind.paint(Wind.x, Wind.y);
};
/**********************************************************************/
/**********************************************************************
 *                      Door                                          * 
 *********************************************************************/
var Door = {};
Door.x = -1000;
Door.y = -1000;

Door.start = function(evnt)
{
	//Canva.clear();
	Door.x = evnt.pageX - posX;
	Door.y = evnt.pageY - posY;
    
	Door.paint(Door.x, Door.y);
    Canva.drawing = true;
};

Door.paint = function(x,y) {
	Canva.ctx.beginPath();
	Canva.ctx.strokeStyle = 'black';
    Canva.ctx.lineWidth = 3;
    Canva.ctx.rect(x-20, y-50, 40, 100);
	Canva.ctx.stroke();
	Canva.ctx.beginPath();
	Canva.ctx.arc(x+15, y, 2, 0 , 2 * Math.PI, false);
	Canva.ctx.stroke();
};

Door.finish = function(evnt)
{	
	Door.x = evnt.pageX - posX;
	Door.y = evnt.pageY - posY;
		
	Canva.drawing = false;
};

Door.move = function(evnt)
{	
	Door.x = evnt.pageX - posX;
	Door.y = evnt.pageY - posY;
	Canva.clear();
	
	Door.paint(Door.x, Door.y);
};
/**********************************************************************
 *                      Roof                                          * 
 *********************************************************************/
var Roof = {};
Roof.x = -1000;
Roof.y = -1000;

Roof.start = function(evnt)
{
	//Canva.clear();
	Roof.x = evnt.pageX - posX;
	Roof.y = evnt.pageY - posY;
    
	Roof.paint(Roof.x, Roof.y);
    Canva.drawing = true;
};

Roof.paint = function(x,y) {
	Canva.ctx.beginPath();
	Canva.ctx.strokeStyle = 'black';
    Canva.ctx.lineWidth = 3;
    Canva.ctx.moveTo(x-170, y+170);
	Canva.ctx.lineTo(x+170, y+170);	
	Canva.ctx.lineTo(x, y);
	Canva.ctx.lineTo(x-170, y+170);
	Canva.ctx.stroke();
};

Roof.finish = function(evnt)
{	
	Roof.x = evnt.pageX - posX;
	Roof.y = evnt.pageY - posY;
		
	Canva.drawing = false;
};

Roof.move = function(evnt)
{	
	Roof.x = evnt.pageX - posX;
	Roof.y = evnt.pageY - posY;
	Canva.clear();
	
	Roof.paint(Roof.x, Roof.y);
};
/**********************************************************************
 *                      Tube                                          * 
 *********************************************************************/
var Tube = {};
Tube.x = -1000;
Tube.y = -1000;

Tube.start = function(evnt)
{
	//Canva.clear();
	Tube.x = evnt.pageX - posX;
	Tube.y = evnt.pageY - posY;
    
	Tube.paint(Tube.x, Tube.y);
    Canva.drawing = true;
};

Tube.paint = function(x,y) {
	Canva.ctx.beginPath();
	Canva.ctx.strokeStyle = 'black';
    Canva.ctx.lineWidth = 3;
    Canva.ctx.moveTo(x,y+10);
	Canva.ctx.lineTo(x, y-10);
	Canva.ctx.lineTo(x+10, y-5);
	Canva.ctx.lineTo(x, y);
	Canva.ctx.stroke();
};

Tube.finish = function(evnt)
{	
	Tube.x = evnt.pageX - posX;
	Tube.y = evnt.pageY - posY;
		
	Canva.drawing = false;
};

Tube.move = function(evnt)
{	
	Tube.x = evnt.pageX - posX;
	Tube.y = evnt.pageY - posY;
	Canva.clear();
	
	Tube.paint(Tube.x, Tube.y);
};
/**********************************************************************/


			Canva.init('canvas', 800, 600);
			
	$('body').on('change', 'input[name=tool]', function() {
		var selTool = $(this).val();
		switch (selTool) {
			case 'Pencil' : Canva.setTool(Pencil);
			break;
			case 'roof' : Canva.setTool(Roof);
			break;
			case 'wind' : Canva.setTool(Wind);
			break;
			case 'door' : Canva.setTool(Door);
			break;
			case 'tube' : Canva.setTool(Tube);
			break;
			case 'wall' : Canva.setTool(Wall);
			break;
			default: Canva.setTool(Wall);
			break;
			
		}
		return false;
	});		
	
	$('body').on('click', '#clearCanvas', function() {
		Wall.x = -1000;
		Wall.y = -1000;
		Wind.x = -1000;
		Wind.y = -1000;
		Roof.x = -1000;
		Roof.y = -1000;
		Tube.x = -1000;
		Tube.y = -1000;
		Door.x = -1000;
		Door.y = -1000;
		Canva.clear();
	});
	
	$('body').on('click', '#close-popup', function() {
		$('.popup').hide("slow");
		return false;
	});
	
	$('body').on('click', '#resh', function() {
		
		var flagPainted = true;
		if (Door.x < 0 || Wind.x < 0 || Roof.x < 0 || Wall.x < 0 || Tube.x < 0) {
			flagPainted = false;
		}
		
		var flagWindow = false;
		if ((Wind.x+50) < (Wall.x+150) 
			&& (Wind.x-50) > (Wall.x-150) 
			&& (Wind.y+25) < (Wall.y+75)
			&& (Wind.y-25) > (Wall.y-75)) {
				flagWindow = true;
		}
		
		var flagDoor = false;
		if ((Door.x+20) < (Wall.x+150+5) 
			&& (Door.x-20) > (Wall.x-150-5) 
			&& (Door.y+50) < (Wall.y+75+5)
			&& (Door.y-50) > (Wall.y-75-5)) {
				flagDoor = true;
		}
		
		var flagDoorWindow = false;
		dwX = Math.abs(Door.x - Wind.x);
		dwY = Math.abs(Door.y - Wind.y);
		if (dwX > (20+50) || dwY > (50+25)) {
				flagDoorWindow = true;
		}
		
		var flagRoofWall = false;
		dwX = Math.abs(Roof.x - Wall.x);
		dwY = Math.abs(Roof.y - Wall.y);
		if (dwX < (10) && dwY > (170+75-5) && dwY < (170+75+5)) {
				flagRoofWall = true;
		}	
		
		var flagTube = false;
		dwX = Math.abs(Roof.x - Tube.x);
		dwY = Math.abs(Roof.y - Tube.y);
		if (dwX < (5) && dwY < (15) && dwY > 0 && Tube.y < Roof.y) {
				flagTube = true;
		}			
		
		var clr = "error";
		var msg = "";
		if (flagPainted = true) {
			if (flagWindow) {
				if (flagDoor) {
					if (flagDoorWindow) {
						if (flagRoofWall) {
							if (flagTube) {
								msg = "Дом распознан";
								clr = "success";
							}
							else {
								msg = "Подравняйте флюгер";
							}
						}
						else {
							msg = "Крыша не выровнена";
						}
					}
					else {
						msg = "Дверь не должна пересекать окно";
					}
				}
				else {
					msg = "Дверь не внутри стен";
				}
			}
			else {
				msg = "Окно не внутри стен";
			}
		}
		else {
			msg = "Не нарисованы все терминальные элементы";
		}
		
		$('body').popup(clr, msg);
		
	});
	
	$('body').on('click', '#gener', function() {
		Canva.clear();
		Wall.x = 400;
		Wall.y = 300;
		Wind.x = 450;
		Wind.y = 280;
		Roof.x = 400;
		Roof.y = 55;
		Tube.x = 400;
		Tube.y = 50;
		Door.x = 300;
		Door.y = 325;
		Canva.paintAll();
	});
});