function repositionAdd(){
	$("#addLink").css('position', 'absolute');
	$("#addLink").css('left', $("#container").offset().left+940);
	$("#addLink").css('top', 20);
	$("#addLink").css('font-size', 30);
}

function repositionJump(){
	$("#jumping").css('position', 'absolute');
	$("#jumping").css('left', $("#container").offset().left+30);
	$("#jumping").css('top', 30);
	$("#jumping").css('font-size', 30);
}

function repositionReturn(){
	$("#return").css('position', 'absolute');
	$("#return").css('left', $("#container").offset().left+430);
	$("#return").css('top', 550);
	$("#return").css('font-size', 30);
}

function jump(targ,selObj,restore){
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function add(){
	window.location = "/add";
	/*$.ajax({
	   type: "POST",
	   url: "submit.php",
	   data: "",
	   success: function(msg){
	     //alert( "Data Saved: " + msg );
	   }
	 });*/
}