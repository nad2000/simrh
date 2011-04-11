$(window).resize(function(){
	$("#newbody").css("height",( $(window).height()-45 )+'px');
	$("#newbody").css("width",($(window).width())+'px');
});


//-------------------------------------------------------
	var isEqual = function(x) {
   // returns true if x is numeric and false if it is not.
   var RegExp = /^(-)?(\d*)(\.?)(\d*)$/; 
   return String(x).match(RegExp);
}
	var isNumeric = function(x) {
   // returns true if x is numeric and false if it is not.
   var RegExp = /^(-)?(\d*)(\.?)(\d*)$/; 
   return String(x).match(RegExp);
}
	
	if(!Array.indexOf){
	    Array.prototype.indexOf = function(obj){
	        for(var i=0; i<this.length; i++){
	            if(this[i]==obj){
	                return i;
	            }
	        }
	        return -1;
	    }
	}
	
	
	function establecefuncionalidaddetabs()
	{
		 var temp=[];
		 
		 $(".tab").each(function(i){
//		   if(temp!=$(this).attr('class').split(' ')[1])
//		   {temp=$(this).attr('class').split(' ')[1];} 	
			//alert(temp.indexOf($(this).attr('class').split(' ')[1]);	   
		   if( -1==temp.indexOf($(this).attr('class').split(' ')[1]) )
		   {  temp.push( $(this).attr('class').split(' ')[1] ); }
		   else{$(this).css('display','none');}
		   
		   establecelinksdetabs($(this),$(this).attr('class').split(' ')[1]);
		 });	
	}	
	
	
	function establecelinksdetabs(elem,tabfam)
	{
		//alert(elem.attr('class'));

		$(".tablink", elem).each(function(i){
			$(this).css("cursor","pointer");
			$(this).unbind('click');	
		   	$(this).click(function () { 
				//alert($(this).attr('class')+i);
				clickdetabs(tabfam,i);
			});
		});

	}

	function clickdetabs(tabfam,numeroamostrar)
	{
		//alert(tabfam);
		 $("."+tabfam).each(function(i){
		   if(i!=numeroamostrar){$(this).css('display','none');}
		   else{$(this).css('display','block');}
		 });		
	}	
	
	
	
	

// Idea by:  Nic Wolfe -->
//This script and many more are available free online at -->
// The JavaScript Source!! http://javascript.internet.com -->
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=250,height=340');");
}

function popUpCedula(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=1,statusbar=0,menubar=0,resizable=1,width=1000,height=550');");
}
