$(document).ready(function() {
    $('.sidebar-menu li.active .sidebar-sub-menu.expand').css({'display' : 'block'});
    $('.sidebar-menu li a').on('click', function() {
        $(this).toggleClass('active').parent().siblings().children().removeClass('active');
        $(this).closest('li').toggleClass('active').siblings().removeClass('active');
        $(this).closest('li').children('.sidebar-sub-menu').toggleClass('expand').slideToggle();
        $(this).closest('li').siblings().children('.sidebar-sub-menu').removeClass('expand').slideUp();
    });

    $('.sidebar-header .fa-bars').on('click', function() {
        $('.sidebar').toggleClass('sidebar-collapsed');
        $('.content').toggleClass('content-collapsed');
        $('.navigation').toggleClass('navigation-collapsed'); 
        $('.sidebar .sidebar-menu-text, .sidebar .sidebar-sub-menu-text, .sidebar .fa-angle-left, .sidebar .brand-name, .sidebar .fa-bars').show();
    });

    $('body').on('mouseenter', '.sidebar-collapsed', function() {
        var width = $(window).width();
        if (width > 768) {
            $(this).css({'overflow' : 'hidden', 'width' : '200px'});
            $('.sidebar .sidebar-menu-text, .sidebar .sidebar-sub-menu-text, .sidebar .fa-angle-left, .sidebar .brand-name, .sidebar .fa-bars').show();
        }
        else {
            $(this).css({'overflow' : 'hidden', 'width' : '60px'}); 
            $('.sidebar .sidebar-menu-text, .sidebar .sidebar-sub-menu-text, .sidebar .fa-angle-left, .sidebar .brand-name, .sidebar .fa-bars').hide();
        }
    }).on('mouseleave', '.sidebar-collapsed', function() {
        $(this).css({'overflow' : 'hidden', 'width' : '60px'});
        $('.sidebar .sidebar-menu-text, .sidebar .sidebar-sub-menu-text, .sidebar .fa-angle-left, .sidebar .brand-name, .sidebar .fa-bars').hide();
    });
    

    $('.card-body-collapsed').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).closest('.card').children('.card-body').toggleClass('expand').slideToggle();
    });

    $(document).on('click', '.card-collapsed', function(e) {
        e.preventDefault();
        $(this).closest('.card').parent().addClass('hide').slideUp();
    });

    $(document).on('click', function() {
        $('.dropdown-menu.active').removeClass('active');
    });
    
    $('.dropdown').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).children('.dropdown-menu').toggleClass('active');
    });

    $('.dropdown-item').on('click', function() {
        window.location.href = $(this).find('a').attr('href');
    });

    $('.accordion a').on('click', function() {
        var prevTarget = $('.accordion a.active').data('target');
        var target = $(this).data('target');
        
        if(prevTarget != target) {
            $(this).parent().children().removeClass('active')
            $(this).addClass('active')
            $('.accordion-item').addClass('hide').slideUp();
            $(target).removeClass('hide').slideDown()
        }
    })
})
