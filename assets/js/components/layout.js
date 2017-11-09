export default (function () {

    $(document).ready(function () {
        $(".button-collapse").sideNav();
        $(".dropdown-button").dropdown({constrain_width: false, hover: false, beloworigin: true});
    });

    self.transparentNavbar = function () {
        let navbarContainer = document.querySelector(".transparent-navbar");
        if(navbarContainer)
        {
            let navbar = navbarContainer.firstElementChild;
            let nav = navbar.firstElementChild;
            let navWrapper = nav.firstElementChild;

            navWrapper.classList.add('transparent');
            nav.classList.add('z-depth-0');
            navWrapper.classList.remove('grey');
            document.querySelector('.brand-logo').classList.add('hide');
        }
    };

    self.coloredNavbar = function () {
        let navbarContainer = document.querySelector(".transparent-navbar");
        if(navbarContainer)
        {
            let navbar = navbarContainer.firstElementChild;
            let nav = navbar.firstElementChild;
            let navWrapper = nav.firstElementChild;

            navWrapper.classList.remove('transparent');
            nav.classList.remove('z-depth-0');
            navWrapper.classList.add('grey');
            document.querySelector('.brand-logo').classList.remove('hide');
        }
    };

    self.scrolledNavbar = function () {
        let position = $(window).scrollTop(); // should start at 0

        if(position < 100 )
        {
            self.transparentNavbar();
        }

        $(window).scroll(function() {
            let scroll = $(window).scrollTop();
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
                // fullWidth: true
            });
        });
    }();

    self.slider = function () {
        $(document).ready(function () {
            $('.slider').slider({full_width: true, height: 600});
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

    self.sideUserNav = function () {
        $('.button-collapse2').sideNav({
            menuWidth: 300, // Default is 240
            edge: 'right', // Choose the horizontal origin
            closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
        });
    }();

    self.datepickers = function () {
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 5, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd',
            close: 'Valider'
        });

        $('.birthdate').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 100,
            min: new Date(new Date().setFullYear(new Date().getFullYear() - 80)),
            max: true,
            format: 'yyyy-mm-dd',
            close: 'Valider'
        });


    }();

})();
