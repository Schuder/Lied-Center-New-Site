$(function(){
  
    function filtered() {        // define event handler
      $this = $(this);
      $triangle = '&#x25BA';
      $this.toggleClass('filtered').siblings().removeClass('filtered');
    }

    $('#legend li').click(filtered);  // attach event handler
    
});