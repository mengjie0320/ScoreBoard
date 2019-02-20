function setCookie(cname,cvalue,exdays)					/*设置cookie，有三个参数*/
			{
			  var d = new Date();
			  d.setTime(d.getTime()+(exdays*24*60*60*1000));
			  var expires = "expires="+d.toGMTString();
			  document.cookie = cname + "=" + escape(cvalue) + "; " + expires;
			}
			 
function getCookie(cname)							/*获取cookie，一个参数*/
			{
			  var name = cname + "=";
			  var ca = document.cookie.split(';');
			  for(var i=0; i<ca.length; i++) 
			  {
			    var c = ca[i].trim();
			    if (c.indexOf(name)==0) return unescape(c.substring(name.length,c.length));
			  }
			  return "";
			  
			}
function delCookie(cname){//为cookie name
   var date = new Date();
   date.setTime(date.getTime() - 10000);
   document.cookie = cname + "=a; expires=" + date.toGMTString();
   
}