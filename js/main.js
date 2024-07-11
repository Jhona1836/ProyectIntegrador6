$(document).ready(function () {
    // Almacenamos la identida de la página
    let page = document.head.querySelector('meta[name="page-identity"]')['content'];

    // ------------------------------- GENERAL
    $('.menu-toggle input').on('click', () => {
        console.log('p')
        $('.list-nav').toggleClass('show');
    })
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 100) {
            $('.menu').addClass('sticky');
            $('.headerContent').addClass('pt-40');
        } else {
            $('.headerContent').removeClass('pt-40');
            $('.menu').removeClass('sticky');
        }
    })

    // ----- Newsletter
    show('bottom', '.newsletter');

    // ----- Footer
    show('bottom', 'footer');

    // ------------------------------- HOME
    if (page === 'home') {
        // Slider
        var topJourneysSwiper = new Swiper('.topJourneysSwiper', {
            slidesPerView: 3,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
            },
            breakpoints: {
                // when window width is >= 320px
                1450: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
                1151: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            },
            loop: true
        })

        document.getElementById('nexSlide').onclick = () => {
            document.querySelector('.swiper-button-next').click();
        }

        // reveal
        // ----- Why Horizon
        show('bottom', '.whyHorizonTitle');
        show('left', '.whyHorizonCaracteristicas .caracteristica');
        show('right', '.whyHorizonContent');
        show('bottom', '.whyHorizonImages');

        // ----- Top Journeys
        show('left', '.topJourneysContent');
        show('right', '.swiper');

        // ----- About Horizon
        show('top', '.aboutHorizonGallery .photo:first-child');
        show('right', '.aboutHorizonGallery .photo:nth-child(2)');
        show('left', '.aboutHorizonGallery .photo:nth-child(3)');
        show('bottom', '.aboutHorizonGallery .photo:last-child');
        show('right', '.aboutHorizonContent');

        // ----- Resume Banner
        show('top', '.resumeBanner .resumeItem h3');
        show('bottom', '.resumeBanner .resumeItem h2');

        // ----- Our History
        show('left', '.ourHistoryContent');

        // ----- Horizon Features
        show('left', '.feature:first-child');
        show('bottom', '.feature:nth-child(2)');
        show('right', '.feature:last-child');
    
        // ----- Horizon Team
        show('bottom', '.ourTeamTitle');

        // ----- Why Horizon
        show('left', '.teamMember:first-child');
        show('bottom', '.teamMember:nth-child(2)');
        show('top', '.teamMember:nth-child(3)');
        show('right', '.teamMember:last-child');
    }

    // ------------------------------- DESTINATIONS
    if (page === 'destinations') {
        // ----- SPAIN
        show('left', '.spainContent');
        show('left', '.spainImages .image:first-child', '150px');
        show('right', '.spainImages .image:last-child', '150px');
        // ----- SPAIN AACTIVITIES
        show('bottom', '.spainActivities h2');
        show('left', '.spainActivities .activities-container .activity:first-child');
        show('top', '.spainActivities .activities-container .activity:nth-child(2)');
        show('right', '.spainActivities .activities-container .activity:nth-child(3)');
        show('bottom', '.spainActivities .activities-container .activity:nth-child(4)');
        show('right', '.spainActivities .activities-container .activity:last-child');
        // ----- SPAIN MONUMENTS
        show('right', '.spainMonuments h2')
        show('left', '.spainMonuments .monument1Es .content');
        show('right', '.spainMonuments .monument2Es .content');

        // ----- ENGLAND
        show('right', '.englandContent');
        show('left', '.englandImages .image:first-child', '150px');
        show('right', '.englandImages .image:last-child', '150px');
        // ----- ENGLAND AACTIVITIES
        show('bottom', '.englandActivities h2');
        show('left', '.englandActivities .activities-container .activity:first-child');
        show('bottom', '.englandActivities .activities-container .activity:nth-child(2)');
        show('right', '.englandActivities .activities-container .activity:nth-child(3)');
        show('left', '.englandActivities .activities-container .activity:nth-child(4)');
        show('right', '.englandActivities .activities-container .activity:last-child');
        // ----- ENGLAND MONUMENTS
        show('left', '.englandMonuments h2')
        show('right', '.englandMonuments .monument1En .content');
        show('left', '.englandMonuments .monument2En .content');

        // ----- FRANCE
        show('right', '.franceContent');
        show('left', '.franceImages .image:first-child', '150px');
        show('right', '.franceImages .image:last-child', '150px');
        // ----- FRANCE AACTIVITIES
        show('bottom', '.franceActivities h2');
        show('left', '.franceActivities .activities-container .activity:first-child');
        show('top', '.franceActivities .activities-container .activity:nth-child(2)');
        show('right', '.franceActivities .activities-container .activity:nth-child(3)');
        show('left', '.franceActivities .activities-container .activity:nth-child(4)');
        show('bottom', '.franceActivities .activities-container .activity:last-child');
        // ----- FRANCE MONUMENTS
        show('right', '.franceMonuments h2')
        show('left', '.franceMonuments .monument1Fr .content');
        show('right', '.franceMonuments .monument2Fr .content');
    }

    // ------------------------------- JOURNEYS
    if (page === 'journeys') {
        $('.journey-a > .resume button').on('click', (e) => {
            // Obtener el height del a tarjeta y del contenido del acordeon
            let id = '#' + e.target.dataset.toggle;
            let height = $(`${id} > .content .body`).innerHeight();
            let contHeight = $(`${id} > .content`).height();
            if (contHeight != 0) {
                // Hay que cerrar
                $(id + ' > .content').css('min-height', 0);
                $(id + ' > .content').removeClass('open');
                $(id + ' > .content').addClass('closed');
                $(id + ' .resume button').removeClass('btnActive');
                $(id + ' .resume button').html('Read more');
            } else {
                // Hay que abrir
                $(id + ' > .content').css('min-height', height);
                $(id + ' > .content').removeClass('closed');
                $(id + ' > .content').addClass('open');
                $(id + ' .resume button').addClass('btnActive');
                $(id + ' .resume button').html('Read less');
            }
        })

        // ----- REVEALS
        show('bottom', '.journey-a');
        show('left', '.unitedKingdom h2');
        show('right', '.spain h2');
        show('left', '.france h2');
    }

    // ------------------------------- CONTACT
    if (page === 'contact') {
        show('left', '.contactInfo');
        show('right', '.contactForm');
        show('bottom', '.workWithUs .title');
        show('left', '.workWithUs form input[name=name]');
        show('left', '.workWithUs form input[name=email]');
        show('right', '.workWithUs form input[name=phone]');
        show('right', '.workWithUs form input[name=speciality]');
        show('bottom', '.workWithUs form textarea');
        show('bottom', '.workWithUs form button');
        show('left', '.featuredJourneys .title');
        show('bottom', '.featuredJourneys .journey:first-child');
        show('top', '.featuredJourneys .journey:nth-child(2)');
        show('bottom', '.featuredJourneys .journey:last-child');
        show('right', '.featuredDestinations .title');
        show('bottom', '.featuredDestinations .destination:first-child');
        show('top', '.featuredDestinations .destination:nth-child(2)');
        show('bottom', '.featuredDestinations .destination:last-child');
    }
});

// Funcion para acortar el reveal
var show = (origin, element, distance) => {
    distance === undefined ? distance = '100px' : distance;
    ScrollReveal().reveal(element, {
        duration: 450,
        easing: 'ease-in-out',
        delay: 150,
        origin: origin,
        distance: distance
    });
}