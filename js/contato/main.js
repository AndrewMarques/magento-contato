document.observe('dom:loaded', function () {

    var formId = 'hibrido-contato-form';
    var feedbackId = 'hibrido-contato-feedback';

    var $form = $(formId);
    var $feedback = $(feedbackId);

    if ( ! $form || ! $form.length) {
        return;
    }

    var myForm = new VarienForm(formId, true);
    var postUrl = window.hibridoContatoUrl;

    var $button = $form.down('button[type=submit]');
    var buttonTextOld = $button.innerHTML.stripTags();
    var buttonTextLoading = 'Carregando...';

    new Event.observe(formId, 'submit', function(e) {
        e.stop();

        if (myForm.validator.validate()) {
            new Ajax.Request(postUrl, {
                    method: 'post',
                    asynchronous: true,
                    evalScripts: false,
                    onSuccess: function (response) {
                        var json = response.responseJSON;
                        var classe = json.sucesso ? 'sucesso' : 'erro';

                        $feedback.addClassName(classe);
                        $feedback.innerHTML = json.mensagem;
                        $feedback.show();
                    },
                    onComplete: function(request, json) {
                        $button.innerHTML = buttonTextOld;
                        $button.writeAttribute('disabled', false);
                    },
                    onLoading:function(request, json) {
                        $feedback.innerHTML = '';
                        $feedback.hide();
                        $button.innerHTML = buttonTextLoading;
                        $button.writeAttribute('disabled', true);
                    },
                    parameters: $form.serialize(true)
                }
            );
        }
    });


});
