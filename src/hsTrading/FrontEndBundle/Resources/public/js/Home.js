Home = function () {
    this.listProducts = Routing.generate('list_products');
    this.ActionListener();
    this.Scroll();
};

Home.prototype.ActionListener = function ()
{
    var self = this;
    $(".item").
            each(function () {
                var item_view = $(this).
                        find('a.product-review');
                var item = $(this).
                        find('a.product-review').
                        attr("id");
                var title = $(this).
                        find('a.product-review').
                        attr("name");

                self.show(item, item_view, title);
            });

};

Home.prototype.show = function (item, item_view, title)
{
    var self = this;
    item_view.click(function () {
        var options = {
            url: self.listProducts + '/' + item,
            title: title,
            size: 'lg',
            buttons: [
                {
                    text: 'Fermer',
                    style: 'danger',
                    class: 'btn btn-u btn-u-red rounded',
                    close: true
                }
            ]
        };
        eModal.ajax(options);
    });
};

Home.prototype.Scroll = function ()
{
    var self = this;
    $(".link1").click(function (e) {
        $('html,body').animate({
            scrollTop: $(".div1").offset().top - 80},
                'slow');
    });
    $(".link2").click(function (e) {
        $('html,body').animate({
            scrollTop: $(".div2").offset().top - 110},
                'slow');
    });
    $(".link3").click(function (e) {
        $('html,body').animate({
            scrollTop: $(".div4").offset().top - 100},
                'slow');
    });
};
