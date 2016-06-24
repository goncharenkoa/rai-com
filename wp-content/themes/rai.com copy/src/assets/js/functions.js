$( document ).ready(function() {
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
    margin: 20

});
$('#statuts .owl-carousel').owlCarousel({
    items: 2,
    navigation: true,
    margin: 20

});
$('#gallery .owl-carousel').owlCarousel({
    items: 1,
    navigation: true,
    pagination: false

});
$(".go-bot").click(function(){
    $('body, html').animate({ scrollTop: $($(this).attr("href")).position().top }, 400);
    return false;
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
        url: 'http://eri.balakshii.com/?books=last'
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

    //$scope.books = [
    //    {
    //        name: 'Nexus S',
    //        snippet: 'Fast just got faster with Nexus S.'
    //    }, {
    //        name: 'Motorola XOOM™ with Wi-Fi',
    //        snippet: 'The Next, Next Generation tablet.'
    //    }, {
    //        name: 'MOTOROLA XOOM™',
    //        snippet: 'The Next, Next Generation tablet.'
    //    }
    //];
}