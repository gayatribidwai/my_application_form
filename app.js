$(document).ready(function() {
    $('#dob').on('change', function() {
      var dob = $(this).val();
      var age = calculateAge(dob);
      $('#age').val(age);
    });
  





      function calculateAge() {
        var dobInput = document.getElementById('dob');
        var ageInput = document.getElementById('age');
  
        var dob = new Date(dobInput.value);
        var now = new Date();
        var age = now.getFullYear() - dob.getFullYear();
  
        if (now.getMonth() < dob.getMonth() ||
            (now.getMonth() === dob.getMonth() && now.getDate() < dob.getDate())) {
          age--;
        }
  
        ageInput.value = age;
      }


    // function calculateAge(dob) {
    //   var dobDate = new Date(dob);
    //   var today = new Date('2023-06-01');
    //   var age = today.getFullYear() - dobDate.getFullYear();
    //   var m = today.getMonth() - dobDate.getMonth();
    //   if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
    //     age--;
    //   }
    //   return age;
    // }
  
    $('#applicationForm').on('submit', function(e) {
      e.preventDefault();
      var age = parseInt($('#age').val());
      if (age > 30) {
        Swal.fire('Sorry, you can\'t apply.');
      } else {
        Swal.fire('Form submitted successfully.');
        // Here, you can perform the form submission and database operations using PHP and MySQL.
      }
    });
  });
  