(function($) { 
   $.fn.touchWizard = function(settings) {
     var config = {
 			touchLeft: function(e) {
 			    trace("touchLeft");
 			},
 			touchRight: function(e) { 
 			    trace("touchRight:" + e.value); 
 			},
 			touchUp: function(e) { 
 			    trace("touchUp:" + e.value); 
 			},
 			touchDown: function(e) {
 			    trace("touchDown:" + e.value);  
 			},
 			touchMove: function(e) { 
 			    trace("touchMove:" + e.dx + ":" + dy ); 
 			},
 			touchDrag: function(e) {
 			},
 			zoom: function(e) {
 			    trace("zoom:" + e.value);  
 			},
 			dblclick: function(e) { 
 			    trace("dblclick");  
 			},
 			mouseScroll: function(e) { 
 			    trace("mouseScroll:" + e.value);  
 			},
			preventDefaultEvents: true
	 };
     
      
     if (settings) $.extend(config, settings);
 
     this.each(function() {
        var min_move_x = 20;
        var min_move_y = 20 ;
        var clickTime = new Date() ;
        var dblInterval = 300 ; 
        var isScale = false ;
        
        //计算两点间的距离
        function getPointDistance(x1,y1,x2,y2)
        {
            return Math.round(Math.sqrt(Math.pow(x1-x2,2)+Math.pow(y1-y2,2))) ;
        }
        
        
 
        function onTouchStart(e) {
            if (e.touches.length > 1)
                return ;
            isScale = false ;

            //dblclick
            var nowTime = new Date() ;
            var t = parseInt(nowTime.getTime() - clickTime.getTime()) ;
            
            if ((t < dblInterval) && (e.touches.length == 1))
            {
               config.dblclick(e) ;
               return ;
            }
            clickTime = nowTime ;
        
            var touches = e.changedTouches ;
            for (var i=0; i < touches.length; i++) {
                var touch = touches[i] ;
                touch.startX = touch.clientX; 
                touch.startY = touch.clientY; 
            } 
            e.stopPropagation();
        }

        function onTouchMove(e) {
            if (isScale)
                return ;
                
            var touch = e.changedTouches[0] ;
            touch.endX = touch.clientX ;
            touch.endY = touch.clientY ;
            e.dx = touch.startX - touch.endX;
            e.dy = touch.startY - touch.endY;
            config.touchMove(e);
            e.stopPropagation();
        }


        function onTouchEnd(e) {
            if (isScale)
                return ;
            
            var touch = e.changedTouches[0] ;
            touch.endX = touch.clientX ;
            touch.endY = touch.clientY ;
            
            var dx = touch.startX - touch.endX;
            var dy = touch.startY - touch.endY;
            if((Math.abs(dx) >= min_move_x) && (Math.abs(dx)>Math.abs(dy))) {
                e.value = dx ;
                if(dx > 0)
                   config.touchRight(e);
                else
                   config.touchLeft(e);
            }
            else if((Math.abs(dy) >= min_move_y) && (Math.abs(dx)<Math.abs(dy))) {
                e.value = dy ;
                if(dy > 0) 
                    config.touchDown(e);
                else
                    config.touchUp(e);
            }
            e.stopPropagation();
        }

        
        function onGestureStart(e){
            isScale = true ;
            e.stopPropagation();
        }
        
        function onGestureEnd(e){
            e.value = e.scale ;
            config.zoom(e);
            e.stopPropagation();
        }
        
        function onMouseWheel(e)
        {
            var value = (/Firefox/i.test(navigator.userAgent))? e.detail : e.wheelDelta ;
            e.value = value ;
            config.mouseScroll(e);
            e.stopPropagation();
        }
        
        //touchstart gesturestart touchstart gestureend touchend touchend
        this.addEventListener("touchstart", onTouchStart, false);
        this.addEventListener("touchmove", onTouchMove, false);
        this.addEventListener("touchend", onTouchEnd, false);
        this.addEventListener("gesturestart", onGestureStart, false);
        this.addEventListener("gestureend", onGestureEnd, false);
        this.addEventListener((/Firefox/i.test(navigator.userAgent))? "DOMMouseScroll" : "mousewheel", onMouseWheel, false);
     });
 
     return this;
   };
 
 })(jQuery);
