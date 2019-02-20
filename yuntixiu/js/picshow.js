$(function(){
	var url = window.location.href;
	setCookie("url",url,7);
	$("#li_third").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow')  //顶部nav的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	$(".pic").hover(function(){
		$(this).next().show();			//底部关注
	},function(){
		$(this).next().hide();
	});
	var username = getCookie("username");
	var rId = getCookie("reg_id");
	var pId = getCookie("pkId");
	//登录的名字
	function loginName(){
		$(".nav_last").html("").append('<ul><li id="new_li">欢迎您，'+username+'<ul><div class="triangle_up"><span></span></div><p><a href="personcenter.html"><img src="images/homepage/个人中心.png" />个人中心</a></p><p><a href="personcenter.html"><img src="images/homepage/消息.png" />我的消息<i></i></a></p><a href="#" id="login_out"><img src="images/homepage/退出.png" />安全退出</a></ul></li></ul>')
		$("#new_li ul #login_out").click(function(){
			delCookie("username");
			delCookie('reg_id');
			loginOut();
		})
	}
    function loginOut(){
    	window.location.href="login.html";
    }
  
	if(username !== "" && rId !==""){
			loginName();
			
	}else{
		delCookie("reg_id");
	}
	$("#new_li").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow').css({
			'boxShadow':'0 0 10px #ccc',
		})  //显示退出的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	var i=0,//大图编号
		len=img.length,//img数组的长度
		cur=0;//当前图片编号
		j=9,//默认显示小图个数
		page=0,//小图的页码
		$s_next=$('#smallImg-next'),//小图下一页
		$s_pre=$('#smallImg-pre'),//小图上一页
		box=$('#smallImg-box').width(),//显示的长度
		$ul=$('#smallImg-ul'),//小图外层
		$imgLi=$ul.find('li'),//小图li
		html=_html='';//存放载入的代码		
	$('#detailImg-box').append('<a href=\"'+img[0].href+'\" class=\"detailImg_1\"><img alt=\"'+img[0].alt+'\" src=\"'+img[i].src+'\"></a>');
	//大图	
	$('#detailImg-next').click(function(){
		++i;
		detailImg_click($s_next,i,len);
	})
	$('#detailImg-pre').click(function(){
		--i;
		detailImg_click($s_pre,i,len);
	})
	//小图
	for(var k=0;k<j;k++){
		var _k=k%len;
		s_html(_k);
		html+=h;
	}
	$ul.append(html);
	$('.smallImg_1').addClass('cur');	
	//小图下一页
	$('#smallImg-next').click(function(){
		if(!$ul.is(':animated')){
			page++;
			var a=page*j,_a,c;
			for(var k=0;k<j;k++,a++){
				smallImg_click(a,_a,len,i);
				_html+=h;
			}
			$ul.append(_html);
			$ul.css({'left':0,'right':'auto'});
			$ul.animate({left:-box},1600,function(){
				$ul.find('li:lt('+j+')').detach();
				$ul.css('left',0);
				_html='';
			});//动画执行后,再删除前9个li,将left设回0
			$('#smallImg-ul li').click(function(){
				var _this=$(this);
				i=_this.attr('class').replace(/[^0-9]/ig,'')-1;
				img_info(i);
				s_a_r(_this,'cur');
				cur=i;
			})
		}
	})
	//小图上一页
	$('#smallImg-pre').click(function(){
		if(!$ul.is(':animated')){
			page--;
			var a=(page-1)*j,_a,c;
			for(var k=0;k<j;k++,a--){
				smallImg_click(a,_a,len,i);
				_html=h+_html;
			}
			$ul.prepend(_html).css({'right':box,'left':'auto'});
			$ul.animate({right:0},1600,function(){
				$ul.find('li:gt('+(j-1)+')').detach();//删除后9个li,从8开始
				_html='';
			});
			$('#smallImg-ul li').click(function(){
				var _this=$(this);
				i=_this.attr('class').replace(/[^0-9]/ig,'')-1;
				img_info(i);
				s_a_r(_this,'cur');
				cur=i;
			})
		}
			
	})
	//点击小图
	$('#smallImg-ul li').click(function(){
		var _this=$(this);
		i=_this.attr('class').replace(/[^0-9]/ig,'')-1;
		img_info(i);
		s_a_r(_this,'cur');
		cur=i;
	})
})

/*----自定义函数-----------*/
var img=[
	{
		'href':'#',
		'alt':'图片1',
		'src':'images/other/1_b.jpg',
		'smallSrc':'images/other/1_s.jpg',
	},{
		'href':'#',
		'alt':'图片2',
		'src':'images/other/2_b.jpg',
		'smallSrc':'images/other/2_s.jpg',
	},{
		'href':'#',
		'alt':'图片3',
		'src':'images/other/3_b.jpg',
		'smallSrc':'images/other/3_s.jpg',
	},{
		'href':'#',
		'alt':'图片4',
		'src':'images/other/4_b.jpg',
		'smallSrc':'images/other/4_s.jpg',
	},{
		'href':'#',
		'alt':'图片5',
		'src':'images/other/5_b.jpg',
		'smallSrc':'images/other/5_s.jpg',
	},{
		'href':'#',
		'alt':'图片6',
		'src':'images/other/6_b.jpg',
		'smallSrc':'images/other/6_s.jpg',
	},{
		'href':'#',
		'alt':'图片7',
		'src':'images/other/7_b.jpg',
		'smallSrc':'images/other/7_s.jpg',
	},{
		'href':'#',
		'alt':'图片8',
		'src':'images/other/8_b.jpg',
		'smallSrc':'images/other/8_s.jpg',
	},{
		'href':'#',
		'alt':'图片9',
		'src':'images/other/9_b.jpg',
		'smallSrc':'images/other/9_s.jpg',
	},{
		'href':'#',
		'alt':'图片10',
		'src':'images/other/10_b.jpg',
		'smallSrc':'images/other/10_s.jpg',	
	},{
		'href':'#',
		'alt':'图片11',
		'src':'images/other/11_b.jpg',
		'smallSrc':'images/other/11_s.jpg',
	},{
		'href':'#',
		'alt':'图片12',
		'src':'images/other/12_b.jpg',
		'smallSrc':'images/other/12_s.jpg',
	},{
		'href':'#',
		'alt':'图片13',
		'src':'images/other/13_b.jpg',
		'smallSrc':'images/other/13_s.jpg',
	},{
		'href':'#',
		'alt':'图片14',
		'src':'images/other/14_b.jpg',
		'smallSrc':'images/other/14_s.jpg',
	},{
		'href':'#',
		'alt':'图片15',
		'src':'images/other/15_b.jpg',
		'smallSrc':'images/other/15_s.jpg',
	},{
		'href':'#',
		'alt':'图片16',
		'src':'images/other/16_b.jpg',
		'smallSrc':'images/other/16_s.jpg',
	},{
		'href':'#',
		'alt':'图片17',
		'src':'images/other/17_b.jpg',
		'smallSrc':'images/other/17_s.jpg',
	},{
		'href':'#',
		'alt':'图片17',
		'src':'images/other/18_b.jpg',
		'smallSrc':'images/other/18_s.jpg',
	}
]
//大图图片信息
function img_info(i){
	var href=img[i].href,
		alt=img[i].alt,
		src=img[i].src,
		title=img[i].title,
		$main=$('#detailImg-box');
	$main.find('a').attr({'href':href,'class':'detailImg_'+(i+1)});
	$main.find('img').attr({'alt':alt,'src':src});
	$main.find('p').text(title);
}
function s_a_r(o,c){
	o.addClass(c).siblings().removeClass(c);	
}
//大图左右点击
function i_cur(i,len){
	i=i%len;
	if(i<0){
		i=len+i;
	}
	return i;	
}
function detailImg_click($pn,i,len){
	i_cur(i,len);
	img_info(i);
	var imgCur=$('.smallImg_'+(i+1));
	if(!imgCur.html()){
		$pn.click();
	} 
	s_a_r($('.smallImg_'+(i+1)),'cur');//小图选中
}
//小图左右点击
function smallImg_click(a,_a,len,i){
	_a=a;
	_a=a%len;
	if(_a<0){
		_a+=len;
	}
	c=_a==i?'cur':'';
	s_html(_a,c);
}
function s_html(_a,c){
	return h='<li class=\"smallImg_'+(_a+1)+' '+c+'\"><a><img alt=\"'+img[_a].alt+'\" src=\"'+img[_a].smallSrc+'\"></a></li>';
}
