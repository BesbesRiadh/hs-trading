var AdminPanel = function ()
{
    try {
        this.listProducts = Routing.generate('products');
    } catch (e)
    {
        console.log(e);
    }

    this.init();
};

AdminPanel.prototype.init = function () {

    this.initJTable();
};

AdminPanel.prototype.loadBootgrid = function () {
    $('#list').
            bootgrid('reload');
};

AdminPanel.prototype.loading = function (el, message)
{
    $(el).
            attr('disabled', 'disabled').
            addClass('ui-state-disabled');
    $(el).
            text(message);
};

AdminPanel.prototype.endloading = function (el, message)
{
    $(el).
            removeAttr('disabled').
            removeClass('ui-state-disabled');
    $(el).
            text(message);
};


AdminPanel.prototype.initJTable = function ()
{
    var self = this;
    var grid = $("#list").bootgrid({
        ajax: true,
        url: self.listProducts,
        labels: {
            noResults: 'self.Messages.noResults',
            infos: 'self.Messages.pagination_info',
            refresh: 'self.Messages.refresh',
            loading: 'self.Messages.loading',
            all: 'self.Messages.all'

        },
        templates: {
            search: "",
            header: '"<div id="{{ctx.id}}" class="{{css.header}}"><div class="row">\n\
         <div class="col-sm-12 actionBar"><button id="dialog-add-title"\n\
class="btn btn-primary" type="button" title="' + 'self.Messages.add_user_dialog_title' + '"><span class="glyphicon glyphicon-plus"></span></button>\n\
<p class="{{css.actions}}"></p></div></div></div>"'
        },
        formatters: {
            "pix": function (column, row) {
                    return "<img src='" + row.img + "'  style='" + 'width:130px; height:55px;' +"'  />";
                    }
        }
    }).on("loaded.rs.jquery.bootgrid", function ()
    {

    });


};