/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var shiawa_module = (function () {

    var countScrolling = 0;
    self.scrollingIcon = function () {
        //Fonction qui anime le petit scrolling

        if (countScrolling % 2 == 0) {
            $('#scrollicon').animate({
                'margin-top': '30px'
            }, 500);
        } else {
            $('#scrollicon').animate({
                'margin-top': '-30px'
            }, 500);
        }

    };

    $(document).ready(function () {
        setInterval(function () {
            self.scrollingIcon();
            countScrolling++;
        }, 1000);
        $(".button-collapse").sideNav();
        $(".dropdown-button").dropdown({constrain_width: false, hover: false, beloworigin: true});
    });

    self.clickScroll = function () {
        $('.scrolling').click(function () {
            $('html, body').animate({
                scrollTop: $(".article").offset().top
            }, 1500);
        });
    }();

    self.carouselShiawa = function () {
        $(document).ready(function () {
            $('.carousel').carousel({
                dist: 0,
                padding: 40,
                fullWidth: true
            });
        });
    }();

    self.silder = function () {
        $(document).ready(function () {
            $('.slider').slider({full_width: true, height: 600});
        });
        $(document).ready(function () {
            $('.slider-anime').slider({indicators: false, height: 350});
        });
    }();

    self.sly = function () {

        jQuery(function ($) {
            'use strict';

            // -------------------------------------------------------------
            //   Basic Navigation
            // -------------------------------------------------------------
            (function () {
                var $frame = $('#basic');
                var $slidee = $frame.children('ul').eq(0);
                var $wrap = $frame.parent();

                // Call Sly on frame
                $frame.sly({
                    horizontal: 1,
                    itemNav: 'basic',
                    smart: 1,
                    activateOn: 'click',
                    mouseDragging: 1,
                    touchDragging: 1,
                    releaseSwing: 1,
                    startAt: 0,
                    scrollBar: $wrap.find('.scrollbar'),
                    scrollBy: 1,
                    pagesBar: $wrap.find('.pages'),
                    activatePageOn: 'click',
                    speed: 300,
                    elasticBounds: 1,
                    easing: 'easeOutExpo',
                    dragHandle: 1,
                    dynamicHandle: 1,
                    clickBar: 1,
                    // Buttons
                    forward: $wrap.find('.forward'),
                    backward: $wrap.find('.backward'),
                    prev: $wrap.find('.prev'),
                    next: $wrap.find('.next'),
                    prevPage: $wrap.find('.prevPage'),
                    nextPage: $wrap.find('.nextPage')
                });

                // To Start button
                $wrap.find('.toStart').on('click', function () {
                    var item = $(this).data('item');
                    // Animate a particular item to the start of the frame.
                    // If no item is provided, the whole content will be animated.
                    $frame.sly('toStart', item);
                });

                // To Center button
                $wrap.find('.toCenter').on('click', function () {
                    var item = $(this).data('item');
                    // Animate a particular item to the center of the frame.
                    // If no item is provided, the whole content will be animated.
                    $frame.sly('toCenter', item);
                });

                // To End button
                $wrap.find('.toEnd').on('click', function () {
                    var item = $(this).data('item');
                    // Animate a particular item to the end of the frame.
                    // If no item is provided, the whole content will be animated.
                    $frame.sly('toEnd', item);
                });

                // Add item
                $wrap.find('.add').on('click', function () {
                    $frame.sly('add', '<li>' + $slidee.children().length + '</li>');
                });

                // Remove item
                $wrap.find('.remove').on('click', function () {
                    $frame.sly('remove', -1);
                });
            }());

            // -------------------------------------------------------------
            //   Centered Navigation
            // -------------------------------------------------------------
            (function () {
                var $frame = $('#centered');
                var $wrap = $frame.parent();

                // Call Sly on frame
                $frame.sly({
                    horizontal: 1,
                    itemNav: 'centered',
                    smart: 1,
                    activateOn: 'click',
                    mouseDragging: 1,
                    touchDragging: 1,
                    releaseSwing: 1,
                    startAt: 0,
                    scrollBar: $wrap.find('.scrollbar'),
                    scrollBy: 1,
                    speed: 300,
                    elasticBounds: 1,
                    easing: 'easeOutExpo',
                    dragHandle: 1,
                    dynamicHandle: 1,
                    clickBar: 1,
                    // Buttons
                    prev: $wrap.find('.prev'),
                    next: $wrap.find('.next')
                });
            }());

            // -------------------------------------------------------------
            //   Force Centered Navigation
            // -------------------------------------------------------------
            (function () {
                var $frame = $('#forcecentered');
                var $wrap = $frame.parent();

                // Call Sly on frame
                $frame.sly({
                    horizontal: 1,
                    itemNav: 'forceCentered',
                    smart: 1,
                    activateMiddle: 1,
                    activateOn: 'click',
                    mouseDragging: 1,
                    touchDragging: 1,
                    releaseSwing: 1,
                    startAt: 0,
                    scrollBar: $wrap.find('.scrollbar'),
                    scrollBy: 1,
                    speed: 300,
                    elasticBounds: 1,
                    easing: 'easeOutExpo',
                    dragHandle: 1,
                    dynamicHandle: 1,
                    clickBar: 1,
                    // Buttons
                    prev: $wrap.find('.prev'),
                    next: $wrap.find('.next')
                });




                // To Start button
                $wrap.find('.toStart').on('click', function () {
                    var item = $(this).data('item');
                    // Animate a particular item to the start of the frame.
                    // If no item is provided, the whole content will be animated.
                    $frame.sly('toStart', item);
                });

                // To Center button
                $wrap.find('.toCenter').on('click', function () {
                    var item = $(this).data('item');
                    // Animate a particular item to the center of the frame.
                    // If no item is provided, the whole content will be animated.
                    $frame.sly('toCenter', item);
                });

                // To End button
                $wrap.find('.toEnd').on('click', function () {
                    var item = $(this).data('item');
                    // Animate a particular item to the end of the frame.
                    // If no item is provided, the whole content will be animated.
                    $frame.sly('toEnd', item);
                });

                // Add item
                $wrap.find('.add').on('click', function () {
                    $frame.sly('add', '<li>' + $slidee.children().length + '</li>');
                });

                // Remove item
                $wrap.find('.remove').on('click', function () {
                    $frame.sly('remove', -1);
                });
            }());
        });

    }();

    self.changebgOnHover = function () {
        $('.item-episode-accueil').hover(function () {
            //On
            var $bg = $(this).data('bg');


            // $('body').css('background-color', 'rgba(255,255,255,0.8)');
        }, function () {

        });
    }();

    self.initMaterialboxed = function () {
        $(document).ready(function () {
            $('.materialboxed').materialbox();
        });
    }();

    self.initMaterialSelect = function () {
        $(document).ready(function() {
            $('select').material_select();
        });
    }();

    self.initCarousel = function () {
        $('.carousel.carousel-slider').carousel({full_width: true});
    }();

})();