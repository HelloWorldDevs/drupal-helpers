(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.xdebugAjax = {
    attach: function (context, settings) {
      var debugSession = 'XDEBUG_SESSION_START=PHPSTORM'; // Replace 'PHPSTORM' with your IDE key if different.

      // Modify Drupal AJAX options before they are used.
      $(document).ajaxSend(function(event, jqxhr, settings) {
        if (settings.url.indexOf('?') > -1) {
          settings.url += '&' + debugSession;
        } else {
          settings.url += '?' + debugSession;
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
