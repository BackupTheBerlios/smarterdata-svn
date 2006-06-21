function setVariables()
{
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
}
function checkLocationMenu1()
{
	var object = window.document.getElementById('menu1');
	yy=eval(y)+1;
	eval('object'+sD+v+yy);
	setTimeout("checkLocationMenu1()",2);
}
function checkLocationMenu2()
{
	var object = window.document.getElementById('menu2');
	yy=eval(y)+110;
	eval('object'+sD+v+yy);
	setTimeout("checkLocationMenu2()",2);
}
