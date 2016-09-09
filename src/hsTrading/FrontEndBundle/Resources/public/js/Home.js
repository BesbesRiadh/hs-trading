Home = function () {
    this.Scroll();
};

Home.prototype.Scroll = function ()
{
    var self = this;
    $(".link1").click(function (e) {
        $('html,body').animate({
            scrollTop: $(".div1").offset().top -100},
                'slow');
    });
    $(".link2").click(function (e) {
        $('html,body').animate({
            scrollTop: $(".div2").offset().top -600},
                'slow');
    });
    $(".link3").click(function (e) {
        $('html,body').animate({
            scrollTop: $(".div3").offset().top -600},
                'slow');
    });
};
