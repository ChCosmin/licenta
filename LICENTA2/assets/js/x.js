$(document).ready(function() {

  var form = $('#x'),
      nume = $('#nume_utilizator'),
      email = $('#adresa_email'),
      coment = $('#comentariu'),
      id = $('#id_carte'),
      submitComent = $("#submitComent");
      numeErr = $('#numeErr');
      emailErr = $('#emailErr');
      comentErr = $('#comentErr');

      numeErrMsg = emailErrMsg = comentErrMsg = '';
    
  submitComent.on('click', function(e) {
    if(validate()) {
      $.ajax({
        type: "POST",
        url: "/licenta2/actiuni/adauga_comentariu.php",
        data: form.serialize(),
        dataType: "json"
      })
    } else {
      numeErr.html(numeErrMsg);
      emailErr.html(emailErrMsg);
      comentErr.html(comentErrMsg);
    }
  });
  
  function validate() {
    var valid = true;
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email.val())) {
      emailErrMsg = "*Emailul este necesar";
      valid = false;
    } else {
      emailErrMsg = '';
    }
    if($.trim(nume.val()) === "") {
      numeErrMsg = '*Numele este necesar';
      valid = false;
    } else {
      numeErrMsg = '';
    }
    if($.trim(coment.val()) === "") {
      comentErrMsg = '*Campul nu poate fi gol';
      valid = false;
    } else {
      comentErrMsg = '';
    }
    return valid;
  }

});