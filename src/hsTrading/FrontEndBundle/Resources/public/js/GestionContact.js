var GestionContact = function (params)
{
    try {
        this.listContacts = Routing.generate('list_contacts');
        this.editContactURL = Routing.generate('edit_contact');
        this.Messages = $.parseJSON(params.Messages);
    } catch (e)
    {
        console.log(e);
    }

    this.init();
};

GestionContact.prototype.init = function () {

    this.initJTable();
};

GestionContact.prototype.loadBootgrid = function () {
    $('#list').
            bootgrid('reload');
};

GestionContact.prototype.initJTable = function ()
{
    var self = this;
    var grid = $("#list").bootgrid({
        ajax: true,
        url: self.listContacts,
        labels: {
            noResults: self.Messages.noResults,
            infos: self.Messages.pagination_info,
            refresh: self.Messages.refresh,
            loading: self.Messages.loading,
            all: self.Messages.all

        },
        templates: {
            search: ""
        },
        formatters: {
            "action_edit": function (column, row)
            {
                var $affect_td = $('<div></div>');
                var $EditElement = $($("#spanEditElement").
                        html());
                $EditElement.attr('data-row-id', row.id);
                $affect_td.append($EditElement);
                return $affect_td.html();
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function ()
    {
        grid.find(".command-edit").on("click", function (e)
        {
            self.editContact(self.editContactURL + '/' + $(this).
                    data("row-id"));
        });
    });


};

GestionContact.prototype.editContact = function (url) {
    var self = this;

    var options = {
        message: 'Voulez-vous marquer ce contact comme "Traité"?',
        title: 'Confirmation',
        size: 'sm',
        loader: true,
        callback: function (result) {
            if (result)
            {
                $.ajax({
                    type: 'POST',
                    url: url,
                    success: function () {
                        eModal.alert({
                            message: 'Le produit a été marqué comme "Traité"',
                            title: 'Confirmation',
                            size: 'sm',
                            useBin: true
                        });
//                        window.location.reload();
                        self.init();
                        self.loadBootgrid();
                    },
                    error: function (jqXHR, event)
                    {
                        if (jqXHR.status === 400) {
                            alert('error');
                            eModal.alert({
                                message: 'Une erreur est survenue',
                                title: 'Erreur',
                                size: 'sm',
                                useBin: true
                            });
                        }
                    }
                });
            }
        }
    };
    eModal.confirm(options);
};