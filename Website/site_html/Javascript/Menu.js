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
var lockindex_left=false;
var lockmenu2=false;
function lockindex_left()
{
	if(lockindex_left==false)
		lockindex_left=true;
	else
		lockindex_left=false;
}
function lockMenu2()
{
	if(lockmenu2==false)
		lockmenu2=true;
	else
		lockmenu2=false;
}
function checkLocationindex_left()
{
	if(lockindex_left==false)
	{
		var object = window.document.getElementById('index_left');
		yy=eval(y)+1;
		eval('object'+sD+v+yy);
		setTimeout("checkLocationindex_left()",1);
	}
	else
	{
		setTimeout("checkLocationindex_left()",1000);
	}
}
function checkLocationMenu2()
{
	if(lockmenu2==false)
	{
		var object = window.document.getElementById('menu2');
		yy=eval(y)+121;
		eval('object'+sD+v+yy);
		setTimeout("checkLocationMenu2()",1);
	}
	else
	{
		setTimeout("checkLocationMenu2()",1000);
	}
}
