function repositionAdd(){
	$("#addLink").css('position', 'absolute');
	$("#addLink").css('left', $("#container").offset().left+940);
	$("#addLink").css('top', 7);
	$("#addLink").css('font-size', 30);
}

function repositionAddBLink(){
	$("#addBusinessLink").css('position', 'absolute');
	$("#addBusinessLink").css('left', $("#container").offset().left+840);
	$("#addBusinessLink").css('top', 40);
	$("#addBusinessLink").css('font-size', 30);
}

function repositionJump(){
	$("#jumping").css('position', 'absolute');
	$("#jumping").css('left', $("#container").offset().left+30);
	$("#jumping").css('top', 10);
	$("#jumping").css('font-size', 30);
	// I have to find a better place for this...
	jQuery.fn.center = function () {
				    this.css("position","absolute");
				    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
				    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
				    return this;
				}
}

function repositionReturn(){
	$("#return").css('position', 'absolute');
	$("#return").css('left', $("#container").offset().left+430);
	$("#return").css('top', 550);
	$("#return").css('font-size', 30);
}

function repositionSearch(page){
	if(page == "search"){
		$("#searchwrapper").css('position', 'absolute');
		$("#searchwrapper").css('left', $("#container").offset().left+(($("#container").width()/2)-($("#searchwrapper").width()/2)));
		$("#searchwrapper").css('top', 70);
		$("#searchwrapper").css('font-size', 30);
		$("#jumping").css('top', 33);
		$("#purchases").css('margin-top', 55)
	}else{
		if(page == "index"){
			$("#search").css('position', 'absolute');
			$("#search").css('left', $("#container").offset().left);
			$("#search").css('top', 40);
			$("#search").css('font-size', 30);
		}
	}
}

function inline_instructions(){
	var hover = $("#instructions_hover");
	var position = hover.position();
	var offset_h = ((0.5*$("#instructions").height())-(0.5*$("#instructions_hover").height()));
	var offset_w = ((0.5*$("#instructions").width())-(0.5*$("#instructions_hover").width()));
	$("#instructions").css('top', (position.top-offset_h)+"px");
	$("#instructions").css('left', (position.left-offset_w)+"px");
	$("#instructions_hover").mouseover(function(){
		$("#instructions_hover").animate({opacity:0});
		$("#instructions").animate({opacity:0.9});
	});
	$("#instructions_hover").mouseout(function(){
		$("#instructions_hover").animate({opacity:1});
		$("#instructions").animate({opacity:0});
	});
}

function right_instructions(){
	var offset = 10;
	$("#instructions").css('right', offset+"px");
	$("#instructions").css('top', offset+"px");
	var top = ((0.5*$("#instructions").height())-(0.5*$("#instructions_hover").height()));
	var right = ((0.5*$("#instructions").width())-(0.5*$("#instructions_hover").width()));
	$("#instructions_hover").css('position', 'absolute');
	$("#instructions_hover").css('top', (top+offset)+"px");
	var topp = $("#instructions_hover").css('top');
	$("#instructions_hover").css('right', (right+offset)+"px");
	var rightt = $("#instructions_hover").css('right');
	//alert(topp +" "+ rightt);
	$("#instructions_hover").mouseover(function(){
		$("#instructions_hover").animate({opacity:0});
		$("#instructions").animate({opacity:0.9});
	});
	$("#instructions_hover").mouseout(function(){
		$("#instructions_hover").animate({opacity:1});
		$("#instructions").animate({opacity:0});
	});
}

function success(){
	$(".success").center();
	$(".success").fadeToggle(1000, "linear").delay(2000).fadeToggle(1000, "linear");
}

function goToSearch(){
	window.location = "/search";
}

function jump(targ,selObj,restore){
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function add(){
	window.location = "/add";
}

function toggleDebitSelected(){
	var form = document.getElementById("inputform");
	if(form.debit.checked){
		debitSelected(form);
	}else{
		debitUnselected(form);
	}
}

function debitSelected(form){
	alert("Inputform "+inputform);
	form.card.options[0] = null;
	form.card.options[1] = null;
}

function debitUnselected(form){
	form.card.options[0] = new Option("NONE", "NULL", true, true);
	form.card.options[1] = new Option("Interac", "RBC/Interac", false, false);
	form.card.options[2] = new Option("Citizen's Bank", "Citizens Bank", false, false);
}

function getAddPage(){
	/*if($("div#add").height() < 200){
		$("div#add").addClass("add");
		$("div#add").animate({height:250},"slow");
		$("div#add").animate({width:535}, "slow");
		$("div#add").delay(1000).load("add_business.html");
		$("#add").css('position', 'absolute');
		$("#add").css('left', ($(window).width()/2)-(560/2));
		$("#add").css('top', ($(window).height()/2)-(250/2));
	}else{
		$("div#add").animate({height:0}, "slow");
		$("div#add").animate({width:0}, "slow").delay(10000).removeClass("add");
	}*/
	window.location = "/add_business";
}

function urlencode (str) {
    // URL-encodes string  
    // %          note 1: This reflects PHP 5.3/6.0+ behavior
    // %        note 2: Please be aware that this function expects to encode into UTF-8 encoded strings, as found on
    // %        note 2: pages served as UTF-8
    // *     example 1: urlencode('Kevin van Zonneveld!');
    // *     returns 1: 'Kevin+van+Zonneveld%21'
    // *     example 2: urlencode('http://kevin.vanzonneveld.net/');
    // *     returns 2: 'http%3A%2F%2Fkevin.vanzonneveld.net%2F'
    // *     example 3: urlencode('http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a');
    // *     returns 3: 'http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a'
    str = (str+'').toString();
    // Tilde should be allowed unescaped in future versions of PHP (as reflected below), but if you want to reflect current
    // PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
}