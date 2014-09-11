$(document).ready(function(event) {

  var $context;

  window.App = new (function Application() {});

  $context = $('#container');


  App.methods = {

    bindFormEvents : function () {
      var $form;
      var request;

      $form = $context.find('form');

      $form.on('submit', function (event) {
        event.preventDefault();
        request = App.methods.submitUrl($context.find('#longUrl').val());

        request
        .done(App.methods.successAction)
        .fail(App.methods.failAction);
      });

    },

    bindInfoEvents : function () {
      $context.find('.changelog a').on('click tap', App.methods.displayChangelog);
    },

    submitUrl : function (url) {
      return $.ajax({
        url: '/api/addLink',
        type: 'PUT',
        dataType: 'json',
        data: { url: url },
      });
      
    },

    successAction : function (response) {
      if (!response.error) {
        if (response.zonk) {
          $context.find('[data-error-container]').removeClass('show');
          // $context.empty();
          var zonk = $context.find('[data-zonk-container]');
          if (zonk && zonk.length === 0) {
            $context.append(
              $('<p/>', {
                class : 'zonk',
                'data-zonk-container': '',
                html  : response.msg
              }
            ));
            $context.find('form input').attr("disabled", "disabled");
          }
        }
        else {
          var $urlBox;

          $urlBox = $context.find('[data-url-container]');
          $urlBox.html('<a href="' + response.fullURL + '">' + response.fullURL + '</a>');
          $context.find('[data-error-container]').removeClass('show');
          $context.find('[data-zonk-container]').remove();
          $urlBox.addClass('show');
          $context.find('form input').attr("disabled", "disabled");
        }
      }
      else {
        App.methods.failAction(response);
      }
    },

    failAction : function (response) {
      var $errorBox;

      $errorBox = $context.find('[data-error-container]');
      $context.find('[data-zonk-container]').remove();
      $errorBox.html(JSON.parse(response.responseText).msg);
      $errorBox.addClass('show');
    },

    displayChangelog : function (event) {
      if (event) { event.preventDefault(); }
      $context.find('.changelog ul').toggleClass('hidden');
    }
  };

  App.init = function () {
    App.methods.bindFormEvents();
    App.methods.bindInfoEvents();
  };

  App.init();
});