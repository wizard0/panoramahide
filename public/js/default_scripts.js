
// исходное
$(function(){
    /*--Строками или колонками--*/
    $(document).on('click', '.view-type input', function(){
        $('.article-texts-holder').toggleClass("flex-wrap");
        if ($('#grid-view').is(':checked')) {
            $('.article-item').addClass("col-6");
            $('.magazine-item').addClass("col-xl-6");
            $('.out-issn').addClass("col-xl-6");
            $('.goto-issue').addClass("pad24");
            $('.get-access-red').addClass("col-xl-6");
            $('.get-access-red').removeClass("d-flex");
            $('.magazine-footer').removeClass("row");
        } else {
            $('.article-item').removeClass("col-6");
            $('.magazine-item').removeClass("col-xl-6");
            $('.get-access-red').removeClass("col-xl-6");
            $('.get-access-red').addClass("d-flex");
            $('.out-issn').removeClass("col-xl-6");
            $('.goto-issue').removeClass("pad24");
            $('.magazine-footer').addClass("row");
        }
    });
    /*--Строками или колонками--*/

    /*--Показать/Скрыть аннотацию--*/
    $(document).on('click', '.show-annotation a', function(event) {
        event.preventDefault();
        var anntopen = $(this).closest('.article-item').find('.annotation');
        $(anntopen).toggleClass("hidden");
        if ($(anntopen).hasClass("hidden")) {
            $(this).text(MESS.SHOW_ANNOTATION)
        } else {
            $(this).text(MESS.HIDE_ANNOTATION)
        }
    });
    /*--Показать/Скрыть аннотацию--*/

    /*--Показать подсказку--*/
    $('[data-toggle="tooltip"]').tooltip();
    /*--Показать подсказку--*/

    /*-- Адаптивное меню --*/
    var win = $(this);
    if (win.width() < 992) {
        /*--Главное меню--*/
        $('nav').addClass('navmenu navmenu-fixed-left offcanvas');
        /*--Меню журнала--*/
        $('.inner-menu .toggleMenu').addClass('collapse');
        /*--Корзина--*/
        $('.cart-holder li').removeClass('dropdown');

    } else {
        /*--Главное меню--*/
        $('nav').removeClass('navmenu navmenu-fixed-left offcanvas');
        /*--Меню журнала--*/
        $('.inner-menu .toggleMenu').removeClass('collapse');
        /*--Корзина--*/
        $('.cart-holder li').addClass('dropdown');
    }
    /*-- Адаптивное меню --*/

    /*-- Выбор даты --*/
    var win = $(this);
    if (win.width() >= 768) {
        /*--На мобильном устройстве выводится стандартный инструмент выбора даты--*/
        $(function() {
            $('#datetimepicker6').datetimepicker({
                format: 'DD.MM.YYYY'
            });
            $('#datetimepicker7').datetimepicker({
                useCurrent: false,
                format: 'DD.MM.YYYY',
                widgetPositioning: {
                    horizontal: 'right'
                }
            });

            $("#datetimepicker6").on("dp.change", function(e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker7").on("dp.change", function(e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });
        });
        $(".date").prop('type', 'text');
    }
    /*-- Выбор даты --*/

    /*--Подсказка ВАК--*/
    $(document).on('click', '.vak a', function(e) {
        e.stopPropagation();
        $('.vak-tooltip').toggle();
        e.preventDefault();
    });
    /*--Подсказка ВАК--*/

    /*--Кнопка гамбургера--*/
    $('.hamburger a').on('click', function(e) {
        $(this).toggleClass("hCross");
        e.preventDefault();
    });
    /*--Кнопка гамбургера--*/
});
