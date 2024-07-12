// Boostrap Scrollspy
$('body').scrollspy({
  target: '#navbarNav'
});

// Animations
var $cardDeck = $('.card-deck');
var $mailingList = $('.mailing-list');
var $socialLinks = $('.social-icons');

$cardDeck.waypoint(function(direction) {
  if (direction == 'down') {
    $cardDeck.addClass('animated fadeInUp');
  }
}, {
  offset: '50%'
});

$socialLinks.mouseover(function(){
  $(this).addClass('animated pulse');
});

$socialLinks.mouseleave(function(){
  $(this).removeClass('animated pulse');
});

// File Select
// $(".custom-file-input").on("change", function() {
//   var fileName = $(this).val().split("\\").pop();
//   $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
// });

// Google Map

function initMap() {
  var baslerScreenPrinting = {lat: 38.586810, lng: -90.227110};
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 17, center: baslerScreenPrinting});
  var marker = new google.maps.Marker({position: baslerScreenPrinting, map: map});
}

// Form Validation

(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
