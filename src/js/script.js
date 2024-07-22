$(document).ready(function () {
  $("#addProductButton").click(function () {
    $("#addProductForm").toggle(); // Toggle display of add product form

    // Toggle button text and icon based on form visibility
    if ($("#addProductForm").is(":visible")) {
      $("#addProductButton").html('<i class="bi bi-arrow-left"></i> Annuler');
    } else {
      $("#addProductButton").html('<i class="bi bi-plus"></i> Ajouter');
    }
  });

  // Afficher/masquer la barre de catégories en cliquant sur le bouton
  $("#toggleNav").click(function () {
    $("#nav-cat").toggle();
  });

  $("#togglePassword").click(function () {
    if ($("#password").attr("type") === "password") {
        $("#password").attr("type", "text");
        $(".iconPass").removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
        $(this).html(
            '<i class="bi bi-eye-slash-fill p-2 iconPass"></i> Masqué le mode passe'
        );
    } else {
        $("#password").attr("type", "password");
        $(".iconPass").removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
        $(this).html('<i class="bi bi-eye-fill p-2 iconPass"></i> Affiche le mode passe');
    }
});


$("#togglePasswordCn").click(function () {
  if ($("#pwdConf").attr("type") === "password") {
      $("#pwdConf").attr("type", "text");
      $(".iconPassCn").removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
      $(this).html('<i class="bi bi-eye-slash-fill p-2 iconPassCn"></i> Masqué le mot de passe de Confirmation');
  } else {
      $("#pwdConf").attr("type", "password");
      $(".iconPassCn").removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
      $(this).html('<i class="bi bi-eye-fill p-2 iconPassCn"></i> Affiche le mot de passe de Confirmation');
  }
});
$("#pwdConf").on("input", function () {
  var password = $("#password").val();
  var passwordConfirm = $(this).val();

  // Vérifier si le champ de confirmation du mot de passe est vide
  if (passwordConfirm === "") {
      $("#password, #pwdConf").css({
          "background-color": "",
          "color": ""  // Réinitialiser les styles par défaut
      });
      return; // Sortir de la fonction si vide
  }

  // Vérifier si les mots de passe correspondent
  if (password === passwordConfirm) {
      $("#password, #pwdConf").css({
          "background-color": "lightgreen",
          "color": "black"  // Réinitialiser la couleur du texte en noir lorsque les mots de passe correspondent
      });
  } else {
      $("#password, #pwdConf").css({
          "background-color": "salmon",
          "color": "white"  // Changer la couleur du texte en blanc lorsque les mots de passe ne correspondent pas
      });
  }
});


});
