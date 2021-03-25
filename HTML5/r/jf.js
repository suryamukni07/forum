var large_scroll;
function loaded() {
	large_scroll = new iScroll('large-wrapper', { 
	    hScroll: true,
	    vScroll:true,
	    momentum: true,
        zoom: false, //Default zoom status  
        zoomMin: 1,
        zoomMax: 4, 
        //wheelAction: 'scroll',
	    checkDOMChanges: true
	    });
}

document.addEventListener('DOMContentLoaded', loaded, false);

var config ;
var audioClip ;
var mode = 0 ;
var mute = false ;
var device = "PC" ;
var screenSize = {width:$(window).width(),height:$(window).height()}
var initSize = {width:$("#magazine").width(),height:$("#magazine").height()}
var pageIndex = 1 ;
var bookPos = {top:40,right:0,bottom:10,left:0}
var isLarge = false ; // 0 book 1 large

var clickTime = new Date() ;
var clickSP = 300 ;

var pageMode = "HTML" ; // HTML IMG

function loadSetting()
{
    $.ajax({
        url: "setting.xml",
        dataType: "xml",
        success: function (xml){
			var js = "" ;
		   $("*",$(xml).children()).each(function(){
				if (js != "")
					js += "," ;
				 js += this.tagName + ":'" + filter($(this).text()) + "'" ;
		   });
		   
		   config = eval("({" + js + "})") ;
//		   config.maxpagewidth = config.maxpagewidth * 2 ;
//		   config.maxpageheight = config.maxpageheight * 2 ;
		   initPage();
		   
		   if (config.thumbnails == 0)
		        $(".menu-thumb").hide();   
		   if (config.sharebutton == 0)
		        $(".menu-share").hide();
		   if (config.aboutbutton == 0)
		        $(".menu-help").hide();
		   if (config.downloadpdf == 1)
		        $(".controls .menu-right").prepend("<li class='cmditem menu-down'><a href='" + config.pdfurl + "' target='_blank'></a></li>");

         },
        error: function (xhr, ajaxOptions, thrownError) {
            //alert(xhr.status) ;
            //alert(xhr.responseText);
            $("#error").show();
            $("#error_local").show();
            $("#preload").hide();
             
        }
    });	
}


/*Initial page*/
function initPage()
{
    config.pages = new Array(config.pagecount);
    for(var i=0 ;i<config.pagecount ;i++)
        config.pages[i] = "page" + (i+1) ;
    audioClip = document.getElementById("audio-clip");
    
    
    //pageIndex = checkHash();
    
    var paramPageIndex = getUrlParam("page") ;
    if (paramPageIndex != null)
    {
        if (paramPageIndex < 1)
            paramPageIndex = 0 ;
        if (paramPageIndex > config.pages)
            paramPageIndex = config.pages ;
        pageIndex =  paramPageIndex ;     
    }

       
    $("#lbl_Author").html(config.ad_author);
    $("#lbl_Title").html(config.ad_title);
    $("#lbl-PageCount").html(config.pagecount);
    $("#lbl_Url").html(location.href.replace(location.hash,""));
    $(".book-nav").mouseover(function(){$(this).addClass("book-nav-over");})
    $(".book-nav").mouseout(function(){$(this).removeClass("book-nav-over");})
    
    if (config.bgcolor == undefined)
        config.bgcolor = "#888888" ;
    $("body").css("background-color",config.bgcolor) ; 
       
    if (config.bgimage != undefined)
        $("body").css("background-image","url(" + config.bgimage + ")") ; 
        
    if (config.bgsound == undefined)
        config.bgsound = "" ;

 
    document.title = config.ad_title;
        
    initLarge() ;    
    initBook();    
    initThumb();
    loadShow();
    
    

    
	/* Window events */
	$(window).bind('keydown', function(e){
	    if (e.keyCode==37) // → left
		    prev();
	    else if (e.keyCode==39) // ← right
		    next();
	    if (e.keyCode==48) // 0 thumb
		    thumb();
	    if ((e.keyCode==107) && (! isLarge)) // +
		    loadLarge();
	    if ((e.keyCode==109) && (isLarge)) // -
		    loadBook();
			    
	}).bind('hashchange', function() {
			var page = checkHash();
			if (config.pages!=$("#magazine").turn('page'))
			    $("#magazine").turn('page', page);
	}).bind('orientationchange', function() {
		resizeViewPort();
	}).resize(function() {
		resizeViewPort();
	}).click(function() {
		//thumb();
	});

    resizeViewPort();
    bookReset();
    $("#preload").hide();
    $("#entity").show();
}

//
function resizeViewPort()
{
    screenSize = {width:$(window).width(),height:$(window).height()};
    
    /*
    //Show single page when IPAD is vertical
    if (device !="PC")
    {
        mode = screenSize.width > screenSize.height?0:1 ;
        $("#magazine").turn('display', mode == 0?"double":"single");
    }
    */
    

    //set book
    bookPos.left  = $("#book-nav-left").width() ;
    bookPos.right = $("#book-nav-right").width();
   
    var book_container_width = screenSize.width - bookPos.left - bookPos.right ;
    var book_container_height = screenSize.height - bookPos.top - bookPos.bottom ;
    var book_width = mode ==1?config.pagewidth: config.pagewidth*2 ;
    var book_height = config.pageheight ;
    initSize = getSize(book_container_width,book_container_height,book_width,book_height) ;

    var _left1 = (screenSize.width -  initSize.width)/2- $('#book-nav-left').width() ;
    var _top = bookPos.top ;
	//_top = (document.body.clientHeight-book_height)/2;
    if ((screenSize.height - initSize.height) / 2 > _top)
        _top = (screenSize.height - initSize.height) / 2 - _top  ;
    $('#book-nav-left').css({height:initSize.height,top:_top,left:_left1});
    $('#book-nav-right').css({height:initSize.height,top:_top,right:_left1});
    _left1 = _left1 + bookPos.left ;
    _left1 = 0 ;
    $("#magazine").turn('size', initSize.width,initSize.height).css({top:_top,left:_left1});

    // set large
    var pos = getCenterPos(screenSize.width,screenSize.height - $("#book-header").height(),config.maxpagewidth,config.maxpageheight) ;
    $("#large-scroller").width(config.maxpagewidth).height(config.maxpageheight).css(pos);
    
    // set thumb
    var arrow_w = 30;
    thumb_container_width =  screenSize.width - (arrow_w * 2)  ;
    $("#thumb-pages").css("left",arrow_w).width(thumb_container_width);

    $("#book-container,#large-container").height(screenSize.height);
   

}


/*BOOK boject*/
function initBook()
{
    initSize = {width:(mode == 1)?config.pagewidth:config.pagewidth*2,height:config.pageheight}
	$("#magazine").turn({
        gradients: !$.isTouch, acceleration: false, elevation: 50,
        display:(mode == 1)? 'single':'double',
        page: pageIndex,
		pages: config.pagecount,
        width:initSize.width,
        height:initSize.height,
		when: {
			turning: function(e, page, view) {
				var range = $(this).turn('range', page);
				for (page = range[0]; page<=range[1]; page++) 
					addPage(page, $(this));
			},

			turned: function(e, page) {
				pageIndex = page ;
				bookReset();
				
			}
		}
	});

}

 

//Set the page status
function bookReset()
{
    var showLeft = false ;
    var showRight = false ;
    
    if (pageIndex >1)
        showLeft = true ;
    if (pageIndex <config.pagecount)
        showRight = true ;
    
    if (showLeft)
        $('#book-nav-left').show();
    else
        $('#book-nav-left').hide();
        
    if (showRight)
        $('#book-nav-right').show();
    else
        $('#book-nav-right').hide();

    /*
    var pagewidth = initSize.width/2 ;
	if (pageIndex == 1)
	{
	    $("#magazine").css({width:pagewidth,left: pagewidth/2}) ;
	}
	else if (pageIndex == config.pagecount)
	{
	    $("#magazine").css({width:pagewidth,left:-pagewidth/2}) ;
	}
	else if ($("#magazine").width() != pagewidth*2)
	{
	    $("#magazine").css({width:pagewidth*2,left:0}) ;
	    $("#magazine").turn('size', initSize.width,initSize.height);
	}
	*/

}

function addPage(page, book) {

	if (!book.turn('hasPage', page)) {
		book.turn('addPage', getPage(page), page);
	}
}

function getPage(_pageIndex)
{
    if (pageMode == "HTML")
        return getPageByHTML(_pageIndex) ;
    else
        return getPageByIMG(_pageIndex) ;
    
}
function getPageByHTML(_pageIndex)
{
	
	var element = $('<div />', {'class': 'page '+((_pageIndex%2==0) ? 'odd' : 'even'), 'id': 'page-'+ _pageIndex }).html('<i class="loader"></i>');

    $.ajax({
      url: "m/" + _pageIndex + ".htm",
      dataType:"html",
      cache: false,
      success: function(_inhtml){

		    var _page = $(_inhtml) ;
		    _page.dblclick(function(e){
		        loadLarge(_pageIndex);
		    });
		    _page.bind("touchstart",function(e){
                var nowTime = new Date() ;
                var t = parseInt(nowTime.getTime() - clickTime.getTime()) ;
                //dblclick
                if ((t < clickSP) && (e.originalEvent.touches.length == 1))
                    loadLarge(_pageIndex);
                clickTime = nowTime ;
		    });

            element.html(_page);
      }
    }); 
	return element ;
}

function getPageByIMG(page)
{
	var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page}).html('<i class="loader"></i>');
    var url = (mode == 0?"m":"m") + "/" + page + ".jpg" ;
    var img=new Image();
    img.onload=function(){
        var _inhtml = "" ;
        
        //double shadow
        if (mode == 0)
            _inhtml = "<div class='" + ((page%2==0) ? 'oddp' : 'evenp') + "'></div>" ;
		var _page = $("<div style='background-image:url(" + url + ");' class='page'" +  " >" + _inhtml + "</div>") ;
		_page.dblclick(function(e){
		    loadLarge(page);
		});
		_page.bind("touchstart",function(e){
            var nowTime = new Date() ;
            var t = parseInt(nowTime.getTime() - clickTime.getTime()) ;
            //dblclick
            if ((t < clickSP) && (e.originalEvent.touches.length == 1))
                loadLarge(page);
            clickTime = nowTime ;
		});

        element.html(_page);
    };
    img.src=url;
	return element ;
}



function initLarge()
{
    $("#large-scroller").bind("touchstart",function(e){
        var nowTime = new Date() ;
        var t = parseInt(nowTime.getTime() - clickTime.getTime()) ;
        if ((t < clickSP) && (e.originalEvent.touches.length == 1))
            loadBook();
        clickTime = nowTime ;
    })
}

function loadLarge(_pageIndex)
{
    $("#btn_zoom").addClass("menu-zoomout");     
    isLarge = true ;
    $("#book-container").hide();
    $("#large-container").show();
    
    $("#large-scroller").html('<i class="loader"></i>');
    if (_pageIndex != undefined)
        pageIndex = _pageIndex ;
    

    $.ajax({
      url: "l/" + _pageIndex + ".htm",
      dataType:"html",
      cache: false,
      success: function(_inhtml){
		    $("#large-scroller").html(_inhtml).dblclick(function(){loadBook(pageIndex)});
      }
    });



    $("#large-nav-left,#large-nav-right").hide();
    if (pageIndex > 1)
        $("#large-nav-left").show();
    if (pageIndex < config.pagecount)
        $("#large-nav-right").show();
        
}

function largeLeft()
{
    loadLarge(pageIndex-1); 
}
function largeRight()
{
    loadLarge(pageIndex+1); 
}

function loadBook(_pageIndex)
{
    $("#btn_zoom").removeClass("menu-zoomout");     
    isLarge = false ;
    $("#book-container").show();
    $("#large-container").hide();
    $("#magazine").turn('page',_pageIndex);
    bookReset();
}
function loadShow(_isLarge)
{
    if (_isLarge != undefined)
        isLarge = _isLarge ;
   
   if (! isLarge)
   {
        loadBook(pageIndex) ;
        isLarge = false ;
   }
   else
   {
        loadLarge(pageIndex) ;
        isLarge = true ;
   }

}





//thumb
var thumb_container_width =  0 ;
var thumb_left = 0 ;
function initThumb()
{

    //bulid thumb
	var html = '<div id="thumblist"><table id="thumblist-entry" cellpadding="0" cellspacing="0" border="0"><tr>' ;
	for(var i=1;i<=config.pagecount;i++)
		html += "<td><a href='javascript:' onclick='thumbTo(" + i + ",event);' class='" + (i%2 == 1?"thumb-odd":"thumb-even") + "'><img src='s/" + i + ".jpg'><br>" + i + "</a></td>" ;
	html += "<tr></table></div>" ;
	$('#thumb-pages').html(html) ;
	
	$(".thumblist li").each(function(e){
		 var index = e ;
		 $(this).click(function(){
			gotopage(index+1);
		 }) 
	})
    $("#thumb-nav-left").addClass("disable");
    
    
    $("#book-container,#large-container").click(function(){
        //Click to hide
        if ($("#thumb-content").is(":visible")) 
            thumb() ;

    })

    $("#thumblist").touchWizard({
        touchLeft:thumbLeft,
        touchRight:thumbRight
    });

}

 
function thumbLeft(e)
{
    thumbSlide("left");
    e.stopPropagation();
}
function thumbRight(e)
{
    thumbSlide("right");
    e.stopPropagation();
}
function thumbSlide(action)
{
    var value = 0 ;
    var rate = thumb_container_width / 2; //Moving length
    if (action == "right")
        value = thumb_left - rate ; 
    else
        value = thumb_left + rate ;


    if ( (value> 0) || (Math.abs(value) > $("#thumblist").width()))
        return ;
        
    thumb_left = value ;
    
    $("#thumblist").animate({left:thumb_left}, "slow");
    
    if ((value + rate) > 0)
        $("#thumb-nav-left").addClass("disable");
    else
        $("#thumb-nav-left").removeClass("disable");
        
    if (Math.abs(value - rate) > $("#thumblist").width())
        $("#thumb-nav-right").addClass("disable");
    else
        $("#thumb-nav-right").removeClass("disable");
}
function thumbTo(page,e)
{
    $("#thumb-content").slideToggle();
    gotopage(page);
    e.stopPropagation();
}

function first()
{
    if (! isLarge)
	    $("#magazine").turn('page',1);
    else
        loadLarge(1);
}
function prev()
{
    if (! isLarge)
	    $("#magazine").turn('previous');
    else
        loadLarge(pageIndex - 1);
	
}
function next()
{
    if (! isLarge)
	    $("#magazine").turn('next');
    else
        loadLarge(pageIndex +1);
}
function last()
{
    if (! isLarge)
	    $("#magazine").turn('page',config.pagecount);
    else
        loadLarge(config.pagecount);
    
}

function gotopage(page)
{
    if (! isLarge)
	    $("#magazine").turn('page',page);
    else
        loadLarge(page);
}

function thumb()
{
	$("#thumb-content").slideToggle();
}


 
function playAudio(type) {
    //alert(type);
    //audioClip.src = "r/" + type + ".mp3" ;
    //audioClip.play();
}

function pauseAudio() {
    audioClip.pause();
}


function setMute() {
    mute = !mute ;
    audioClip.muted = mute ;
    $("#btn_sound").toggleClass("menu-mute");
    setCookie("mute",mute?1:0);

    if (config.bgsound != "")
        document.getElementById('audio-bgsound').muted=mute;

    
} 

function help()
{
	$('#win-help').modal({
        containerCss: {width: 400,height: 200},
	});
}

function share()
{
	$('#win-share').modal({
        containerCss: {width: 400,height: 200},
	});
}

function shareto(flag)
{
    var shareTitle = "You may be interested in this flash page-flip book" ;
    var shareBody = "Folks, take a look at this cool  flipping book.%0a%0d%0a%0d" + location.href ;
    switch(flag)
    {
        case "mail":
            location.href = "mailto:?subject=" +  shareTitle + "&body=" + shareBody ;
            return ;
            break ;
        case "twitter":
            url = "https://twitter.com/intent/tweet?source=webclient&url={Url}&text={Body}"
            break ;
        case "facebook":
            url = "http://www.facebook.com/sharer/sharer.php?u={Url}&t={Body}";
            break ;
        case "google":
            url = "https://twitter.com/intent/tweet?source=webclient&url={Url}&text={Body}"
            break ; 
    }
    url = url.replace("{Url}",location.href).replace("{Body}", shareTitle) ;
    window.open(url) ;
}


function fullscreen()
{

}



//private
function getSize(containerWidth,containerHeight,objWidth,objHeight)
{
    //Adjust accoring to the screen
    var rate = objWidth / objHeight ;
    var zoomType = (containerWidth/containerHeight)>(objWidth/objHeight) ? 1 :0 ;
    
    /*2012-11-2 将缩小去掉，因为内容是HTML不能缩小*/

    if ((zoomType == 0) && (objWidth>containerWidth))
    {
        //Vertical
        objWidth = containerWidth ;
        objHeight = objWidth / rate ;
        
    }

    if ((zoomType == 1) && (objHeight>containerHeight))
    {
        //Landscape
        objHeight = containerHeight ;
        objWidth = objHeight * rate ;
        
    }

    
	//Set to even number
	objWidth = parseInt(objWidth) ;
	if (objWidth % 2 > 0)
	    objWidth = objWidth + 1 ;  
	
	initSize = {width:objWidth,height:objHeight} ;
	
    return initSize ;
}

function getCenterPos(containerWidth,containerHeight,objWidth,objHeight)
{
    var pos = {left:0,top:0};
    if (objWidth < containerWidth)
        pos.left = (containerWidth - objWidth) /2 ;
    if (objHeight < containerHeight)
        pos.top = (containerHeight - objHeight) /2 ;
    return pos ;        
}

function getUrlParam(name,defaultValue) {
    var reg = new RegExp("[?&]" + name + "=([^?&]*)[&]?", "i");
    var match = location.search.match(reg);
    return match == null ? ((defaultValue == undefined)?null:defaultValue) : match[1];
}

function setUrlParam(name,value)
{
    var url = location.href ;
    var urlSearch = location.search ;
    var urlHash = location.hash ;
    var oldValue = getUrlParam(name) ;
    
    url = url.replace(urlSearch,"").replace(urlHash,"") ;

    if (oldValue == null)
        url += (urlSearch == ""?"?":"&") + name + "=" + value ;
    else
        url += urlSearch.replace(name + "=" + oldValue ,name + "=" + value) ;
    url += urlHash ;
    return url ;
}



function getURL() {
	
	return window.location.href.split('#').shift();

}

function getHash() {
	
	return window.location.hash.slice(1);

}



function checkHash(hash) {

	var hash = getHash(), k;
    pageIndex = 1 ;
	if ((k=jQuery.inArray(hash, config.pages))!=-1) {
		$('nav').children().each(function(index, value) { 
			if ($(value).attr('href').indexOf(hash)!=-1) 
				$(value).addClass('on');
			else 
				$(value).removeClass('on');
		});
		pageIndex = k+1;
	}
	
	return pageIndex;
}


function getCookie(c_name)
{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start!=-1)
		{ 
		c_start=c_start + c_name.length+1; 
		c_end=document.cookie.indexOf(";",c_start);
		if (c_end==-1) c_end=document.cookie.length;
		return unescape(document.cookie.substring(c_start,c_end));
		} 
	  }
	return "";
}

function setCookie(c_name,value,expiredays)
{
	var exdate=new Date();exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}    
    
function filter(vInString)
{
    var s = "" + vInString + "";
	while(s.charAt(0)==" ")
	{
		s = s.substring(1);
	}
	while(s.charAt(s.length-1) == " ")
	{
		s = s.substring(0,s.length-1);
	}
	
	s = s.replace(/\'/g,"");
	
	return s;
}
  
 
function trace(msg)
{
    $("#trace").append( "<br>" + msg) ;
}

function checkHTML5()
{    
    try
    {
        var Canvas = document.createElement("canvas")
    	if (Canvas.getContext)
            return true;
    	else
	    return false ;
    } 
    catch(e) 
    {
        return false ;
    }
    
}