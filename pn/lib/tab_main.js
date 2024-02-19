var containerId = '#tabs-container';
var tabsId = '#tabs_1';
var flag = 0;
$(document).ready(function(){
    // Preload tab on page load
    if($(tabsId + ' LI.current A').length > 0){
        loadTab($(tabsId + ' LI.current A'));
    }
    
    $(tabsId + ' A').click(function(){
        if($(this).parent().hasClass('current')){ return false; }
        
        $(tabsId + ' LI.current').removeClass('current');
        $(this).parent().addClass('current');
        
        loadTab($(this));        
        return false;
    });
});

function loadTab(tabObj){
    if(!tabObj || !tabObj.length){ return; }
    $(containerId).addClass('loading');
    $(containerId).fadeOut('fast');	

	document.getElementById('tabs-container-turi').style.display = 'none'; 
    document.getElementById('tabs-container-strah').style.display = 'none'; 
	document.getElementById('tabs-container-avia').style.display = 'none'; 
	document.getElementById('tabs-container-jd').style.display = 'none'; 
	document.getElementById('tabs-container-otel').style.display = 'none'; 
	document.getElementById('tabs-container-auto').style.display = 'none'; 
    document.getElementById(tabObj.attr('href')).style.display = 'block';
}