$(document).ready(function(){
  // Click facebook link
  $('.btn_facebook').live('click', function(event){
    event.preventDefault();
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent($(location).attr('href')) + '&t=' + encodeURIComponent($(document).attr('title')), 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });

  // Click twitter link
  $('.btn_twitter').live('click', function(event){
    event.preventDefault();
    window.open('http://twitter.com/share?url=' + encodeURIComponent($(location).attr('href')), 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });

  // Enable share buttons
  if($('#share').length)
  {
    var buttons = $('#share').attr('rel').split("-");
    for(var key in buttons)
    {
      var button = buttons[key];
      switch(button)
      {
        case "facebook":
          $('<a>').addClass('btn_facebook')
                  .attr('rel', 'nofollow')
                  .attr('title', 'Partager sur facebook')
                  .attr('href', '#')
                  .appendTo($('#share'));
          break;
        
        case "twitter":
          $('<a>').addClass('btn_twitter')
                  .attr('rel', 'nofollow')
                  .attr('title', 'Partager sur twitter')
                  .attr('href', '#')
                  .appendTo($('#share'));
          break;
      }
    }
    $('<span>').css('clear', 'both').css('display', 'block').appendTo($('#share'));
  }
});