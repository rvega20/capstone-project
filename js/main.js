$('a').click(function(){
    $('html, body').animate({
        scrollTop: $( $(this).attr('anchor1') ).offset().top
    }, "slow");
    return false;
});

$( document.body ).on( 'click', '.dropdown-menu li', function( event ) {
 
   var $target = $( event.currentTarget );
 
   $target.closest( '.btn-group' )
      .find( '[data-bind="label"]' ).text( $target.text() )
         .end()
      .children( '.dropdown-toggle' ).dropdown( 'toggle' );
 
   return false;
 
});

/*$(function(){
  $('#registerform').submit(function(e){
    return false;
});
    
    $('#modaltrigger').leanModal();
    $('#modaltrigger1').leanModal();
    $('#Teachertrigger').leanModal();
    $('#Teachertrigger1').leanModal();
});*/

/* $('#blockButton2').click(function() { 
            $('div.test').block({ 
                message: '<h1>Processing</h1>', 
                css: { border: '3px solid #a00' } 
 }); 
 }); 
$(document).ready(function() {
$('div.testing').block({
    message: '<h2>Create a class above first.</h2>',
    css:{        
    border: 'none', 
            padding: '15px', 
            paddingBottom: '20px',
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .7, 
            color: '#fff',
    }
});
});*/