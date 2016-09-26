var Contact = function (params)
{
    this.add_contact = Routing.generate('add_contact');
    this.messages = $.parseJSON(params.Messages);
    this.init();
};

Contact.prototype.init = function () {

    var self = this;
    self.addContact();

};
Contact.prototype.addContact = function ()
{
    var self = this;

    $('#formContact').on('submit', "form", function (e) {
        e.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: self.add_contact,
            data: $(this).serializeArray(),
            beforeSend: function ()
            {
                $('.has-error').remove();
                $('.alert-success').remove();
                var el = $("#send-contact-btn").find('span.spinner');
                el.prev('i').remove();
                el.toggleClass("fa fa-spinner fa-spin");
            },
            success: function (data)
            {
                $('#contactForm')[0].reset();
                var options = {
                    message: self.showMessage(self.messages.contact_confirmation_message),
                    title:  self.showMessage(self.messages.confirmation),
                    size: 'sm',
                    useBin: true,
                    buttons: [
                        {text: self.showMessage(self.messages.close), class: 'btn btn-u btn-u-blue rounded', close: true
                        }]
                };

                eModal.alert(options);
            },
            error: function (jqXHR)
            {
                $('#formContact').
                        html(jqXHR.responseText);

            }
        });
        return false;
    });
};

Contact.prototype.showMessage = function (message) {
    return '<div style="text-align:center;">' + message + '</div>';
};