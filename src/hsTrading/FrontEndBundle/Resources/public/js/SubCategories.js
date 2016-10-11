var SubCategories = function (params)
{
    try {
        this.listSubCategories = Routing.generate('list_sub_categories');
        this.addSubCategoryUrl = Routing.generate('add_sub_category');
//        this.editSubCategoryUrl = Routing.generate('edit_sub_category');
//        this.deleteSubCategoryUrl = Routing.generate('delete_sub_category');
        this.Messages = $.parseJSON(params.Messages);
    } catch (e)
    {
        console.log(e);
    }

    this.init();
    this.addSubCategory();
};

SubCategories.prototype.init = function () {

    this.initJTable();
};

SubCategories.prototype.loadBootgrid = function () {
    $('#list').
            bootgrid('reload');
};

SubCategories.prototype.initJTable = function ()
{
    var self = this;
    var grid = $("#list").bootgrid({
        ajax: true,
        url: self.listSubCategories,
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
class="btn btn-primary" type="button" title="' + 'Ajouter une sous-catégorie' + '"><span class="glyphicon glyphicon-plus"></span></button>\n\
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
            self.editSubCategory(self.editSubCategoryUrl + '/' + $(this).
                    data("row-id"));
        }).end()
                .find(".command-delete").on("click", function (e)
        {
            self.deleteSubCategory(self.deleteSubCategoryUrl + '/' + $(this).
                    data("row-id"));
        })

    });


};

SubCategories.prototype.addSubCategory = function ()
{
    var self = this;
    $('#dialog-add-title').
            on('click', function () {
                var options = {
                    url: self.addSubCategoryUrl,
                    title: 'Ajoutr une sous-catégorie',
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
                                    url: self.addSubCategoryUrl
                                    ,
                                    data: $("#AddSubCategoryForm").
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
                                        $("#AddSubCategoryForm").
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

SubCategories.prototype.deleteSubCategory = function (url)
{
    var self = this;

    var options = {
        message: 'Voulez-vous supprimer cette sous catégorie?',
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
                            message: 'La sous catégorie a a été supprimée',
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


SubCategories.prototype.editSubCategory = function (url)
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
                        data: $("#EditSubCategoryForm").
                                serialize(),
                        success: function () {
                            var options = {
                                message: 'La sous catégorie a été modifiée',
                                title: 'Confirmation',
                                size: 'sm',
                                useBin: true
                            };
                            eModal.alert(options);
                            self.loadBootgrid();

                        },
                        error: function (jqXHR) {
                            $("#EditSubCategoryForm").
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