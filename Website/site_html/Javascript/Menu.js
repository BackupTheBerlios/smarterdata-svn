var y;
var v;
var sD;
if(navigator.appName == 'Microsoft Internet Explorer')
{
	sD= ".style";
	v= ".pixelTop=";
	y= "document.body.scrollTop";
}
else
{
	sD= ".style";
	v= ".top=";
	y= "window.pageYOffset";
}
var lockmenu1=false;
var lockmenu2=false;
function lockMenu1()
{
	if(lockmenu1==false)
		lockmenu1=true;
	else
		lockmenu1=false;
}
function lockMenu2()
{
	if(lockmenu2==false)
		lockmenu2=true;
	else
		lockmenu2=false;
}
function checkLocationMenu1()
{
	if(lockmenu1==false)
	{
		var object = window.document.getElementById('menu1');
		yy=eval(y)+1;
		eval('object'+sD+v+yy);
		setTimeout("checkLocationMenu1()",1);
	}
	else
	{
		setTimeout("checkLocationMenu1()",1000);
	}
}
function checkLocationMenu2()
{
	if(lockmenu2==false)
	{
		var object = window.document.getElementById('menu2');
		yy=eval(y)+110;
		eval('object'+sD+v+yy);
		setTimeout("checkLocationMenu2()",1);
	}
	else
	{
		setTimeout("checkLocationMenu2()",1000);
	}
}
