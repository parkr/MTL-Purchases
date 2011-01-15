// THIS IS INCOMPLETE / NON-FUNCTIONAL
var labelType, useGradients, nativeTextSupport, animate;

(function() {
	
	//Reposition
	$("#data_logo").css('position', 'absolute');
	$("#data_logo").css('left', $("#container").offset().left+($("#data_logo").width/2));
	$("#data_logo").css('top', 10);
	$("#data_logo").css('font-size', 30);
	
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

function bar_graphs(name){
	var barChart = new $jit.BarChart({  
	  //id of the visualization container  
	  injectInto: name,  
	  //whether to add animations  
	  animate: true,  
	  //horizontal or vertical barcharts  
	  orientation: 'vertical',  
	  //bars separation  
	  barsOffset: 20,  
	  //visualization offset  
	  Margin: {  
	    top:5,  
	    left: 5,  
	    right: 5,  
	    bottom:5  
	  },  
	  //labels offset position  
	  labelOffset: 5,  
	  //bars style  
	  type: useGradients? 'stacked:gradient' : 'stacked',  
	  //whether to show the aggregation of the values  
	  showAggregates:true,  
	  //whether to show the labels for the bars  
	  showLabels:true,  
	  //labels style  
	  Label: {  
	    type: labelType, //Native or HTML  
	    size: 13,  
	    family: 'Geneva',  
	    color: 'white'  
	  },  
	  //add tooltips  
	  Tips: {  
	    enable: true,  
	    onShow: function(tip, elem) {  
	      tip.innerHTML = "<b>" + elem.name + "</b>: " + elem.value;  
	    }  
	  }  
	});
	return barChart;
}