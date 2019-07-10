$(document).ready(function(){
  $('#st-trigger-effects').on('click','.menu-icon',function(event) {
  $('#st-container').addClass('st-effect-2');
  $('#st-container').toggleClass('st-menu-open');
  $("select").select2();

  $(window).load(function(){
       $(".scroller").mCustomScrollbar({
      axis:"y" // vertical and horizontal scrollbar
  });
  });


 });

})
