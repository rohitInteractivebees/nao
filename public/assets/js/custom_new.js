$(document).ready(function() {
    $('.banner-list').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        infinite: true,
        speed: 500,
        arrows: true,
        autoplay: true,
        fade:true,
        
    });
    $('.gallery-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        infinite: true,
        prevArrow: '<button type="button" class="slick-prev">←</button>',
        nextArrow: '<button type="button" class="slick-next">→</button>',
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      });
      $('.testimoninal-slider').slick({
        slidesToShow: 1.7,
        slidesToScroll: 1,
        arrows: true,
        infinite: true,
        prevArrow: '<button type="button" class="slick-prev">←</button>',
        nextArrow: '<button type="button" class="slick-next">→</button>',
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1
            }
          }
        ]
      });
      $('.registration-btn').on('click', function(e) {
        e.preventDefault();
        $(this).next('#dropdownMenu').toggleClass('hidden');
        $(this).toggleClass('active');
      });
      $(document).on('click', function (e) {
        if (!$(e.target).closest('#dropdownMenu').length && !$(e.target).closest('.registration-btn').length) {
          $('#dropdownMenu').addClass('hidden');
          $('.registration-btn').removeClass('active');
        }
      });


      // Second Registration
      $('.registration-btn2').on('click', function(e) {
        e.preventDefault();
        $('#dropdownMenu2').toggleClass('hidden');
        $(this).toggleClass('active');
      });
      $(document).on('click', function (e) {
        if (!$('#dropdownMenu2').length && !$(e.target).closest('.registration-btn2').length) {
          $('#dropdownMenu2').addClass('hidden');
          $('.registration-btn2').removeClass('active');
        }
      });

    // Gallery  Tabbing 
       $('.gallery-sec .tab-link').click(function (e) {
        e.preventDefault();
    
        var $this = $(this);
        var tabId = $this.data('tab'); // "gallery-2024" or "gallery-2023"
    
        var $wrapper = $this.closest('.tab-wrapper');
    
        // Remove active class from all tab links in this wrapper
        $wrapper.find('.tab-link').removeClass('active');
        $this.addClass('active');
    
        // Hide all tab panels
        $wrapper.find('.tab-panel').addClass('hidden');
    
        // Show the matching tab panel
        var $targetPanel = $wrapper.find('.tab-panel[data-tab="' + tabId + '"]');
        $targetPanel.removeClass('hidden');
    
        // If the visible panel contains a slick slider, refresh it
        var $slider = $targetPanel.find('.gallery-slider');
        if ($slider.length && $slider.hasClass('slick-initialized')) {
            $slider.slick('refresh');
        }
    });
      window.addEventListener("scroll", function () {
        const header = document.querySelector("header"); // or use your header's class or ID
        if (window.scrollY > 0) {
          header.classList.add("fixed");
        } else {
          header.classList.remove("fixed");
        }
      });
  
    //   Header Menu
    $('.toggle-menu').click(function(e){
        e.stopPropagation(); // Prevent click from bubbling to document
        $('.navigation').toggleClass('active'); 
    });
    $('.close-icon').click(function(){
       $('.navigation').removeClass('active'); 
    });

// Accordion dropdown toggle
$('.navigation li:has(.sub-dropdown) > a').click(function (e) {
    if ($(this).attr('href') === '#' || $(this).attr('href') === 'javascript:void(0);') {
        e.preventDefault();
    }
    e.stopPropagation(); // Prevent bubbling to document

    const $thisLi = $(this).parent('li');
    const $thisDropdown = $(this).siblings('.sub-dropdown');

    // Close other sub-dropdowns
    $('.navigation .sub-dropdown').not($thisDropdown).slideUp(200).removeClass('open');
    $('.navigation li').not($thisLi).removeClass('open');

    // Toggle current sub-dropdown
    $thisDropdown.slideToggle(200).toggleClass('open');
    $thisLi.toggleClass('open');
});

// Sub-sub-dropdown toggle
$('.navigation li:has(.sub-sub-dropdown) > a').click(function (e) {
    if ($(this).attr('href') === '#' || $(this).attr('href') === 'javascript:void(0);') {
        e.preventDefault();
    }
    e.stopPropagation();

    const $thisLi = $(this).parent('li');
    const $thisSubDropdown = $(this).siblings('.sub-sub-dropdown');

    // Close other sub-sub-dropdowns
    $('.navigation .sub-sub-dropdown').not($thisSubDropdown).slideUp(200).removeClass('open');
    $('.navigation li').not($thisLi).removeClass('sub-open');

    // Toggle current sub-sub-dropdown
    $thisSubDropdown.slideToggle(200).toggleClass('open');
    $thisLi.toggleClass('sub-open');
});


// Close navigation when clicking outside
$(document).click(function(e) {
    if (!$(e.target).closest('.navigation, .toggle-menu').length) {
        $('.navigation').removeClass('active');
        // Also close all dropdowns if needed
        $('.navigation .sub-dropdown').slideUp(200).removeClass('open');
        $('.navigation li').removeClass('open');
    }
});

// Winners Tabbing
    // Set default tab and group
    const defaultTab = 'success-2024';
    const defaultGroup = '2024-group-1';
    
    // Show the default view on page load
    showOnlyGroup(defaultTab, defaultGroup);
    
    // Year tab switching
    $('.winner-sec .tab-link').on('click', function (e) {
        e.preventDefault();
        const selectedTab = $(this).data('tab'); // e.g., success-2023 or success-2024
    
        // Remove 'active' from all tab links and add to the clicked one
        $('.tab-link').removeClass('active');
        $(this).addClass('active');
    
        // Hide all tab panels and show the selected one
        $('.winner-sec .tab-panel').addClass('hidden');
        $('.winner-sec .tab-panel[data-tab="' + selectedTab + '"]').removeClass('hidden');
    
        // Automatically show group-1 of the selected year
        const year = selectedTab.replace('success-', ''); // extract 2023 or 2024
        const defaultGroupForTab = year + '-group-1';
        showOnlyGroup(selectedTab, defaultGroupForTab);
    });
    
    // Group dropdown click
    $('.winner-sec .group-link').on('click', function (e) {
        e.preventDefault();
        const selectedGroup = $(this).data('group'); // e.g., 2023-group-2
    
        // Get the parent tab of the clicked group link
        const parentTabLink = $(this).closest('.tab-item').find('.tab-link');
        const activeTab = parentTabLink.data('tab'); // e.g., success-2023
    
        // Ensure the parent tab link becomes active
        $('.tab-link').removeClass('active');
        parentTabLink.addClass('active');
    
        // Show the associated tab panel
        $('.winner-sec .tab-panel').addClass('hidden');
        $('.winner-sec .tab-panel[data-tab="' + activeTab + '"]').removeClass('hidden');
    
        // Show the selected group inside the selected tab
        showOnlyGroup(activeTab, selectedGroup);
    });
    
    // Utility function to show only the selected group within a tab
    function showOnlyGroup(tab, group) {
        const panel = $('.winner-sec .tab-panel[data-tab="' + tab + '"]');
        panel.find('.success-list').addClass('hidden'); // Hide all groups within this tab
        panel.find('.success-list[data-group="' + group + '"]').removeClass('hidden'); // Show selected group
    }
});