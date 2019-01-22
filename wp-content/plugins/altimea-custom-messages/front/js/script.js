"use strict";

;(function($) {
  $(function () {
    $('#js-frm-quote').formValidation({
      locale: 'es_ES',
      framework: 'bootstrap',
      icon: {
        valid: 'icon-check',
        invalid: 'icon-close',
        validating: 'icon-rotate'
      },
      fields: {
        'dni': {
            validators: {
                regexp: {
                    regexp: /^[0-9]+$/i,
                    message: 'Ingresar sólo dígitos'
                }
            }
        },
        'phone': {
          validators: {
            regexp: {
              regexp: /^[0-9]+$/i,
              message: 'Ingresar sólo dígitos'
            }
          }
        }
      }
    }).on('err.field.fv', function(e, data){
      var field = e.target;
      $('small.help-block[data-bv-result="INVALID"]').addClass('hide');
    }).on('success.form.fv', function(e){
      e.preventDefault();

      var $form = $(e.target),
          fv = $(e.target).data('formValidation');

      var msg     = $('#js-form-customer-msg'),
          loader  = $('#js-form-customer-loader');

      loader.removeClass('d-none').addClass('infinite animated d-inline-block');
      msg.removeClass('alert-success alert-danger').text('');

      var data = $form.serialize() + '&nonce=' + AutoclassManagerAjax.nonce + '&action=register_customer';

      $.post(AutoclassManagerAjax.url, data, function(data) {
        $form.data('formValidation').resetForm(true);

        if (data.result) {
            msg.removeClass('d-none').addClass('alert-success');
        } else {
            msg.removeClass('d-none').addClass('alert-danger');
        }

        loader.addClass('d-none').removeClass('infinite animated d-inline-block');
        msg.text(data.msg).fadeIn('slow');

        setTimeout(function(){
          msg.fadeOut('slow', function(){
            $(this).text('').removeClass('alert-success alert-danger').addClass('d-none');
          });
        }, 10000);
      }, 'json').fail(function(err) {          
        $form.data('formValidation').resetForm(true);

        loader.addClass('d-none').removeClass('infinite animated d-inline-block');

        alert('No se pudo realizar la operación solicitada. Por favor vuelva a intentarlo.');
      });
    });
  });
})(jQuery);