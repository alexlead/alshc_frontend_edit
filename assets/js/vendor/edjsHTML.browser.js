var edjsHTML = function(){
	"use strict";
	var t={
		delimiter: function(){
			return"<br/>"
			},
		header: function(t){
			var e=t.data;
			return"<h"+e.level+"> "+e.text+" </h"+e.level+">"
			},
		paragraph: function(t){
			return"<p> "+t.data.text+" </p>"
			},
		list: function(t){
			var e=t.data,n="unordered"===e.style?"ul":"ol",r="";
			return e.items&&(r=e.items.map((function(t){
				return"<li> "+t+" </li>"
				})).reduce((function(t,e){
					return t+e
					}),"")),"<"+n+"> "+r+" </"+n+">"
			},
				
		image: function(t){
			var e=t.data,n=e.caption?e.caption:"Image";
			return'<img src="'+(e.file?e.file.url:"")+'" alt="'+n+'" />'
			},
			
		wpimage: function(t) {
			var e = t.data,
				n = e.url ? e.url : "Image";
			return '<img src="' + (e.url ? e.url : "") + '"  alt="' + n + '" />'
			},
			
		quote: function(t){ 
			var e=t.data;
			return"<figure><blockquote>"+e.text+"</blockquote><cite>"+e.caption +"</cite></figure>"
			}
		};
	function e(t){
		return new Error(' The Parser function of type "'+t+'" is not defined. \n\n  Define your custom parser functions as: https://github.com/pavittarx/editorjs-html#extend-for-custom-blocks ')
		}return function(n){
			return void 0===n&&(n={}),Object.assign(t,n),{
				parse:function(n){
					return n.blocks.map((function(n){
						return t[n.type]?t[n.type](n):e(n.type)
					}))
				},
				parseBlock: function(n){
					return t[n.type]?t[n.type](n):e(n.type)
				}
			}
		}
	}();
