$( document ).ready(function() {
    $(document).foundation();
    var dropdown = new Foundation.DropdownMenu($(".dropdown"), {});

});
//$('#shop .owl-carousel').owlCarousel({
//    nav: true,
//    items: 4,
//    navigation: true,
//    margin: 10
//
//});
$('#news .owl-carousel').owlCarousel({
    items: 4,
    navigation: true,
    margin: 20,
    itemsMobile: [320,2]

});
if ( $(window).width() < 640 ) {
    $('#staff .owl-carousel').owlCarousel({
        items: 1,
        navigation: true,
        pagination: false

    });
}
$('#statuts .owl-carousel').owlCarousel({
    items: 2,
    navigation: true,
    margin: 20,
    itemsMobile: [767,1],
    itemsTablet: [768,2],
    itemsDesktopSmall:	[1150,2]

});
$('#gallery .owl-carousel').owlCarousel({
    items: 1,
    navigation: true,
    pagination: false,
    responsive: true,
    itemsTablet: [768,1],
    itemsDesktopSmall:	[1150,1]

});
$('#history-mobile .history-mobile-carousel').owlCarousel({
    items: 1,
    navigation: true,
    pagination: false,
    responsive: true,
    itemsTablet: [768,1],
    itemsDesktopSmall:	[1150,1]

});
if ( $(window).width() < 640 ) {
    $('#staff .group-slider').owlCarousel({
        items: 1,
        navigation: true,
        pagination: true,
        itemsTablet: [768,1]
    });
}
if ( $(window).width() < 640 ) {
    $('#rules .rules-carousel').owlCarousel({
        items: 1,
        navigation: true,
        pagination: true,
        itemsTablet: [768,1]
    });
}

$(".go-bot").click(function(){
    $('body, html').animate({ scrollTop: $($(this).attr("href")).position().top }, 400);
    return false;
});
$(".go-top").click(function(){
    $('body, html').animate({ scrollTop: 0 }, 400);
    return false;
});
$(".is-dropdown-submenu:before").click(function(){
    $('.is-dropdown-submenu').addClass('hide-submenu');
});

$(document).ready(function() {
    $(".various").fancybox({
        maxWidth	: 800,
        maxHeight	: 600,
        fitToView	: false,
        width		: '70%',
        height		: '70%',
        autoSize	: false,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
    });
});

//Rai Eri modules
angular.module('raiEri', []);

LastItemsController.$inject = ['$scope', '$http','$timeout'];
var app = angular.module('raiEri', []);

app.controller('LastItemsController', LastItemsController);
function LastItemsController($scope,$http,$timeout) {
    $scope.books = [];

    $http({
        method: 'GET',
        url: 'http://www.eri.rai.it/?books=last'
    }).then(function successCallback(response) {
        $scope.books = response.data;
        $timeout(function(){
            $('#shop .owl-carousel').owlCarousel({
                nav: true,
                items: 4,
                navigation: true,
                margin: 10

            });
        }, 1);
        // when the response is available
    }, function errorCallback(response) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
    });

    //MOBILE SUB MENU MOBULE

    $('.btn-back-to-menu').click(function(){
        $(this).parent().css("display","none");
    });
    $(".mobile-menu .menu-item-has-children").each(function(indx,element){
        $(element).prepend('<span class="mob-submenu-arrow">');
        if (($(".mobile-menu .menu-item-has-children").length -1) == indx ){
            $('.mob-submenu-arrow').click(function(){
                $(this).parent().find(".sub-menu").css("display","block");
            });
        }
    });
    $(".mobile-menu .menu-item-has-children .sub-menu").each(function(indx,element){
        $(element).prepend('<span class="btn-back-to-menu"></span>');
        if (($(".mobile-menu .sub-menu").length -1) == indx ){
            $('.btn-back-to-menu').click(function(){
                $(this).parent().css("display","none");
            });
        }
    });
    $(".go-to-video").click(function(){
        if ($(this).hasClass("play")){
            $("#videoBox")[0].play();
            $(this).removeClass("play").addClass("pause");
            return false
        }
        if ($(this).hasClass("pause")){
            $("#videoBox")[0].pause();
            $(this).removeClass("pause").addClass("play");
            return false
        }
    });


}