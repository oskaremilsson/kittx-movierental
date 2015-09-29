(function(){
var w = window.innerWidth;
var h = window.innerHeight;


var elem = document.getElementById("movie-info");
var elemWrapper = document.getElementById("movie-info-wrapper");

if(elem != null) {
	//elemWrapper.style.width = w + "px";
	//elemWrapper.style.minHeight = h + "px";
	//elemWrapper.style.height = elem.offsetHeight + 25 + "px";

	elem.style.left = (w - elem.offsetWidth) / 2  + "px";
	//elem.style.top = (h - elem.offsetHeight) / 2 + "px";

	console.log(viewport().height);

	function viewport() {
	  var e = window, a = 'inner';
	  if (!('innerWidth' in window )) {
	    a = 'client';
	    e = document.documentElement || document.body;
	  }
	  return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
	}
}

})();