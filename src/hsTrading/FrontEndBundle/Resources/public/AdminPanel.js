var AdminPanel = function (params)
{
    try {
        this.listProducts = Routing.generate('products');
        this.editProductURL = Routing.generate('edit_product');
        this.deleteProductURL = Routing.generate('delete_product');
        this.addProductURL = Routing.generate('add_product');
        this.uploadImg = Routing.generate('upload_img');
        this.maxPerPage = $.parseJSON(params.maxPerPage);
        this.Messages = $.parseJSON(params.Messages);
    } catch (e)
    {
        console.log(e);
    }

    this.init();
    this.addProduct();
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

AdminPanel.prototype.showMessage = function (message) {
    return '<div style="text-align:center;">' + message + '</div>';
};


AdminPanel.prototype.initJTable = function ()
{
    var self = this;
    var grid = $("#list").bootgrid({
        ajax: true,
        url: self.listProducts,
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
class="btn btn-primary" type="button" title="' + self.Messages.add_product_dialog_title + '"><span class="glyphicon glyphicon-plus"></span></button>\n\
<p class="{{css.actions}}"></p></div></div></div>"'
        },
        formatters: {
            "pix": function (column, row) {
                return "<img src='" + row.img + "'  style='" + 'width:130px; height:55px;' + "'  />";
            },
            "action_edit": function (column, row)
            {
                var $affect_td = $('<div></div>');
                var $EditElement = $($("#spanEditElement").
                        html());
                $EditElement.attr('data-row-id', row.id);
                $affect_td.append($EditElement);
                return $affect_td.html();
            },
            "action_delete": function (column, row)
            {
                var $affect_td = $('<div></div>');
                var $DeleteElement = $($("#spanDeleteElement").
                        html());
                $DeleteElement.attr('data-row-id', row.id);
                $affect_td.append($DeleteElement);
                return $affect_td.html();
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function ()
    {
        grid.find(".command-edit").on("click", function (e)
        {
            self.editProduct(self.editProductURL + '/' + $(this).
                    data("row-id"));
        }).end()
                .find(".command-delete").on("click", function (e)
        {
            self.deleteProduct(self.deleteProductURL + '/' + $(this).
                    data("row-id"));
        })

    });


};

AdminPanel.prototype.deleteProduct = function (url)
{
    var self = this;

    var options = {
        message: 'Voulez-vous supprimer ce produit?',
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
                            message: 'Le produit a a été supprimé',
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


AdminPanel.prototype.editProduct = function (url)
{
    var self = this;
    var options = {
        url: url,
        title: self.Messages.edit_user_dialog_title,
        size: 'lg',
        buttons: [
            {
                text: self.Messages.cancel_button,
                style: 'danger',
                class: 'btn btn-u btn-u-red rounded',
                close: true,
                click: function (e) {

                }},
            {
                text: self.Messages.button_add,
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
                        data: $("#EditProductForm").
                                serialize(),
                        beforeSend: function ()
                        {
                            self.loading(el, self.Messages.button_add_in_progress);
                        },
                        complete: function ()
                        {
                            self.endloading(el, self.Messages.button_add);
                        },
                        success: function () {
                            var options = {
                                message: self.showMessage(self.Messages.edit_confirmation),
                                title: self.showMessage(self.Messages.confirmation),
                                size: 'sm',
                                useBin: true
                            };

                            eModal.alert(options);
                            self.loadBootgrid();

                        },
                        error: function (jqXHR) {
                            $("#EditProductForm").
                                    html(jqXHR.responseText);
                            $(el).
                                    removeAttr('disabled').
                                    removeClass('ui-state-disabled');
                            spanEl.text(self.Messages.button_add);
                        }
                    });
                }}
        ],
        callback: function () {
            var fileEl = $('#EditProduct_img');
            fileEl.pekeUpload({
                url: self.uploadImg,
                maxSize: 1,
                theme: "bootstrap",
                isLargeBtn: true,
                data: {
                },
                btnText: 'Séléctionnez votre fichier',
                allowedExtensions: 'png|jpg',
                invalidExtError: "Type de fichier refusé",
                onFileError: function (file, error) {
                },
                onFileSuccess: function (file, data) {
                    $('.pekecontainer').
                            html($('#import-succes').
                                    html());
                    $(".progress ").
                            fadeOut('slow');
                }
            });
            fileEl.click(function (e) {
                $('.pekecontainer').
                        html('');
            });
        }
    };

    eModal.ajax(options);

};


AdminPanel.prototype.addProduct = function ()
{
    var self = this;
    $('#dialog-add-title').
            on('click', function () {
                var options = {
                    url: self.addProductURL,
                    title: self.Messages.add_product_dialog_title,
                    size: 'lg',
                    buttons: [
                        {
                            text: self.Messages.cancel_button,
                            style: 'danger',
                            class: 'btn btn-u btn-u-red rounded',
                            close: true,
                            click: function (e)
                            {
                            }
                        },
                        {
                            text: self.Messages.button_add,
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
                                    url: self.addProductURL
                                    ,
                                    data: $("#AddProductForm").
                                            serialize(),
                                    beforeSend: function ()
                                    {
                                        self.loading(el, self.Messages.button_add_in_progress);
                                    },
                                    complete: function ()
                                    {
                                        self.endloading(el, self.Messages.button_add);
                                    },
                                    success: function () {
                                        var options = {
                                            message: self.showMessage('Votre produit a été ajouté'),
                                            title: self.showMessage('Confirmation'),
                                            size: 'sm',
                                            useBin: true
                                        };

                                        eModal.alert(options);
                                        self.loadBootgrid();
                                    },
                                    error: function (data) {
                                        $("#AddProductForm").
                                                html(data.responseText);
                                        $(el).
                                                removeAttr('disabled').
                                                removeClass('ui-state-disabled');
                                        spanEl.text(self.Messages.button_add);
                                    }
                                });
                            }
                        }
                    ],
                    callback: function () {
                        var fileEl = $('#AddProduct_img');
                        fileEl.pekeUpload({
                            url: self.uploadImg,
                            maxSize: 1,
                            theme: "bootstrap",
                            isLargeBtn: true,
                            data: {
                            },
                            btnText: 'Séléctionnez votre fichier',
                            allowedExtensions: 'png|jpg',
                            invalidExtError: "Type de fichier refusé",
                            onFileError: function (file, error) {
                            },
                            onFileSuccess: function (file, data) {
                                $('.pekecontainer').
                                        html($('#import-succes').
                                                html());
                                $(".progress ").
                                        fadeOut('slow');
                            }
                        });
                        fileEl.click(function (e) {
                            $('.pekecontainer').
                                    html('');
                        });
                    }
                };

                eModal.ajax(options);
            });

};