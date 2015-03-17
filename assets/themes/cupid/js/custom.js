
/*$(document).ready(function() {
	
	//Owl Carousel
	var owl = $("#owl-carousel");
 
	owl.owlCarousel({
		items : 10, //10 items above 1824px browser width
		itemsDesktop : [1823,5], //5 items between 1823px and 1024px
		itemsDesktopSmall : [1023,3], // betweem 1023px and 601px
		itemsTablet: [600,1], //2 items between 600 and 0
		itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
	});
	 
	// Custom Navigation Events
	$(".next").click(function(){
		owl.trigger('owl.next');
	})
	$(".prev").click(function(){
		owl.trigger('owl.prev');
	})
	
	//Owl Carousel
	var owl2 = $("#owl-carousel2");
 
	owl2.owlCarousel({
		items : 10, //10 items above 1824px browser width
		itemsDesktop : [1823,5], //5 items between 1823px and 1024px
		itemsDesktopSmall : [1023,3], // betweem 1023px and 601px
		itemsTablet: [600,2], //2 items between 600 and 0
		itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
	});
	 
	// Custom Navigation Events
	$(".next2").click(function(){
		owl2.trigger('owl.next');
	})
	$(".prev2").click(function(){
		owl2.trigger('owl.prev');
	})
});*/

$("input.alert-danger").change(function() {
	$(this).removeClass('alert-danger');
});

$("textarea.alert-danger").keyup(function() {
	$(this).removeClass('alert-danger');
});

$("a.cbp-vm-grid").click(function() {
	$('.list-title').css('display', 'none');
	$('.grid-title').css('display', 'block');
});

$("a.cbp-vm-list").click(function() {
	$('.list-title').css('display', 'block');
	$('.grid-title').css('display', 'none');
});

$(window).scroll(function () {

    if ($(window).scrollTop() + $(window).height() > $('.footer').offset().top) {
        //alert("footer visible");
    } else {
        //alert("footer invisible");
    }
});

