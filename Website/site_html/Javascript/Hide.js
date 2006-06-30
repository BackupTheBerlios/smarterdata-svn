function getNode (nodeId)
{
	if(document.getElementById)
	{
		return document.getElementById( nodeId );
	}
	else if( document.all && document.all( nodeId ) )
	{
		return document.all( nodeId );
	}
	else if( document.layers && document.layers[ nodeId ] )
	{
		return document.layers[ nodeId ];
	}
	else
	{
		return false;
	}
}
function show(object)
{
	getNode(object).style.display = 'block';
	setCookie('display_' + object, 'show');
}
function hide(object)
{
	getNode(object).style.display = 'none';
	setCookie('display_' + object, 'hide');
}
function setCookie( key, value )
{
	document.cookie = key + '=' + value + '; expires=' + new Date(2008, 1, 1).toGMTString();
}