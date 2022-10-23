// (function ($) {
//   $(document).ready(function() {
//   });
// })(jQuery);


// FH Sight form validation
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.querySelectorAll('.needs-validation')
// Loop over them and prevent submission
Array.prototype.slice.call(forms)
  .forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })

//Next Prev buttons for FH-Sight Form
document.addEventListener('click', function (event) {
  if (event.target.matches('.btnNext')) {
    event.preventDefault();
     var nextPillEL = document.querySelectorAll('#pills-tab .active')[0].parentNode.nextElementSibling.getElementsByTagName('button')[0];
     var nextPill = new bootstrap.Tab(nextPillEL);
     nextPill.show();
  }
  else if (event.target.matches('.btnPrev')) {
    event.preventDefault();
    var prevPillEL = document.querySelectorAll('#pills-tab .active')[0].parentNode.previousElementSibling.getElementsByTagName('button')[0];
    var prevPill = new bootstrap.Tab(prevPillEL);
    prevPill.show();
  } else {
    return;
  }
}, false);
