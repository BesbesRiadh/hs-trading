var Categories = function (params)
{
    try {
        this.listContacts = Routing.generate('list_categories');
        this.addCategoryUrl = Routing.generate('add_category');
        this.editCategoryUrl = Routing.generate('edit_category');
        this.deleteCategoryUrl = Routing.generate('delete_category');
        this.Messages = $.parseJSON(params.Messages);
    } catch (e)
    {
        console.log(e);
    }

    this.init();
    this.addCategory();
};

Categories.prototype.init = function () {

    this.initJTable();
};

Categories.prototype.loadBootgrid = function () {
    $('#list').
            bootgrid('reload');
};

Categories.prototype.initJTable = function ()
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
            search: "",
            header: '"<div id="{{ctx.id}}" class="{{css.header}}"><div class="row">\n\
         <div class="col-sm-12 actionBar"><button id="dialog-add-title"\n\
class="btn btn-primary" type="button" title="' + 'Ajouter une catégorie' + '"><span class="glyphicon glyphicon-plus"></span></button>\n\
<p class="{{css.actions}}"></p></div></div></div>"'

        },
        formatters: {
            "action_edit": function (column, row)
            {
                var $affect_td = $('<div></div>');
                var $EditElement = $($("#spanEditElement").
                        html());
                $EditElement.attr('data-row-id', row.code);
                $affect_td.append($EditElement);
                return $affect_td.html();
            },
            "action_delete": function (column, row)
            {
                var $affect_td = $('<div></div>');
                var $DeleteElement = $($("#spanDeleteElement").
                        html());
                $DeleteElement.attr('data-row-id', row.code);
                $affect_td.append($DeleteElement);
                return $affect_td.html();
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function ()
    {
        grid.find(".command-edit").on("click", function (e)
        {
            self.editCategory(self.editCategoryUrl + '/' + $(this).
                    data("row-id"));
        }).end()
                .find(".command-delete").on("click", function (e)
        {
            self.deleteCategory(self.deleteCategoryUrl + '/' + $(this).
                    data("row-id"));
        })

    });


};

Categories.prototype.addCategory = function ()
{
    var self = this;
    $('#dialog-add-title').
            on('click', function () {
                var options = {
                    url: self.addCategoryUrl,
                    title: 'Ajoutr une catégorie',
                    size: 'sm',
                    buttons: [
                        {
                            text: 'Annuler',
                            style: 'danger',
                            class: 'btn btn-u btn-u-red rounded',
                            close: true,
                            click: function (e)
                            {
                            }
                        },
                        {
                            text: 'Ajouter',
                            class: 'btn btn-u btn-u-blue rounded',
                            style: 'info',
                            close: false,
                            click: function (event)
                            {
                                var el = event.currentTarget;
                                var spanEl = $(el).
                                        find('span');
                                $.ajax({
                                    type: 'POST',
                                    url: self.addCategoryUrl
                                    ,
                                    data: $("#AddCategoryForm").
                                            serialize(),
                                    success: function () {
                                        var options = {
                                            message: 'La catégorie a été ajoutée',
                                            title: 'Confirmation',
                                            size: 'sm',
                                            useBin: true
                                        };

                                        eModal.alert(options);
                                        self.loadBootgrid();
                                    },
                                    error: function (data) {
                                        $("#AddCategoryForm").
                                                html(data.responseText);
                                        $(el).
                                                removeAttr('disabled').
                                                removeClass('ui-state-disabled');
                                        spanEl.text(self.Messages.button_add);
                                    }
                                });
                            }
                        }
                    ]
                };

                eModal.ajax(options);
            });

};

Categories.prototype.deleteCategory = function (url)
{
    var self = this;

    var options = {
        message: 'Voulez-vous supprimer cette catégorie?',
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
                            message: 'La catégorie a a été supprimée',
                            title: 'Confirmation',
                            size: 'sm',
                            useBin: true
                        });
                        self.loadBootgrid();
                        self.init();
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


Categories.prototype.editCategory = function (url)
{
    var self = this;
    var options = {
        url: url,
        title: 'Modifier une catégorie',
        size: 'sm',
        buttons: [
            {
                text: 'Annuler',
                style: 'danger',
                class: 'btn btn-u btn-u-red rounded',
                close: true,
                click: function (e) {

                }},
            {
                text: 'Modifier',
                class: 'btn btn-u btn-u-blue rounded',
                style: 'info',
                close: false,
                click: function (event) {
                    var el = event.currentTarget;
                    var spanEl = $(el).
                            find('span');
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $("#EditCategoryForm").
                                serialize(),
                        success: function () {
                            var options = {
                                message: 'La catégorie a été modifiée',
                                title: 'Confirmation',
                                size: 'sm',
                                useBin: true
                            };
                            eModal.alert(options);
                            self.loadBootgrid();

                        },
                        error: function (jqXHR) {
                            $("#EditCategoryForm").
                                    html(jqXHR.responseText);
                            $(el).
                                    removeAttr('disabled').
                                    removeClass('ui-state-disabled');
                            spanEl.text(self.Messages.button_add);
                        }
                    });
                }}
        ]
    };

    eModal.ajax(options);

};