var ContactHistory = function (params)
{
    try {
        this.listContacts = Routing.generate('list_contacts_history');
        this.Messages = $.parseJSON(params.Messages);
    } catch (e)
    {
        console.log(e);
    }

    this.init();
};

ContactHistory.prototype.init = function () {

    this.initJTable();
};


ContactHistory.prototype.initJTable = function ()
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
        }
    }).on("loaded.rs.jquery.bootgrid", function ()
    {

    });


};