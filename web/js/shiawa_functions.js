/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var shiawa_module = (function () {

    $(document).ready(function () {
        $(".button-collapse").sideNav();
        $(".dropdown-button").dropdown({constrain_width: false, hover: false, beloworigin: true});
    });

    self.transparentNavbar = function () {
        var navbarContainer = document.querySelector(".transparent-navbar");
        var navbar = navbarContainer.firstElementChild;
        var nav = navbar.firstElementChild;
        var navWrapper = nav.firstElementChild;

        nav.classList.add('transparent');
        navWrapper.classList.add('transparent');
        nav.classList.add('z-depth-0');
        navWrapper.classList.remove('grey');
    };

    self.coloredNavbar = function () {
        var navbarContainer = document.querySelector(".transparent-navbar");
        var navbar = navbarContainer.firstElementChild;
        var nav = navbar.firstElementChild;
        var navWrapper = nav.firstElementChild;

        nav.classList.remove('transparent');
        navWrapper.classList.remove('transparent');
        nav.classList.remove('z-depth-0');
        navWrapper.classList.add('grey');

    };

    self.scrolledNavbar = function () {
        var position = $(window).scrollTop(); // should start at 0

        if(position < 100 )
        {
            self.transparentNavbar();
        }

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (position > 100) {
                self.coloredNavbar();
            } else {
                self.transparentNavbar();
            }
            position = scroll;
        });
    }();

    self.clickScroll = function () {
        $('.mouse').click(function () {
            $('html, body').animate({
                scrollTop: $(".articles").offset().top - 150
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

    self.slider = function () {
        $(document).ready(function () {
            $('.slider').slider({full_width: true, height: 600});
        });
        $(document).ready(function () {
            $('.slider-anime').slider({indicators: false, height: 350});
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