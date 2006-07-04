function addScrollmenu(id, minPosX)
{
	initMenu(id, minPosX);
}
function initMenu(id, minPos)
{
	for (var i = 0; i < menus.length; i++)
	{
		if(menus[i]["id"] == id)
		{
			return true;
		}
	}
	var Menu = new Object();
	Menu["id"] = id;
	Menu["minPos"] = minPos;
	Menu["lock"] = false;
	menus.push(Menu);
}
function lockMenu(id)
{
	for (var i = 0; i < menus.length; i++)
	{
		if(menus[i]["id"] == id)
		{
			if(menus[i]["lock"] == false)
				menus[i]["lock"] = true;
			else
				menus[i]["lock"] = false;
			return true;
		}
	}
}
function checkMenu()
{
	for(var i = 0; i < menus.length; i++)
	{
		if(menus[i]["lock"] == true)
			continue;
		var object = window.document.getElementById(menus[i]["id"]);
		yy = eval(y);
		if(yy < menus[i]["minPos"])
			yy = menus[i]["minPos"];
		eval('object' + sD + v + yy);
	}
	setTimeout("checkMenu()", menuTimeout);
}
var y;
var v;
var sD;
var menuTimeout= 100;
var menus = new Array();
if(navigator.appName == 'Microsoft Internet Explorer')
{
	sD = ".style";
	v = ".pixelTop=";
	y = "document.body.scrollTop";
}
else
{
	sD = ".style";
	v = ".top=";
	y = "window.pageYOffset";
}
checkMenu();