// POST
$(document).on("click", "#btn-add", function (e) {
  // on informe l'utilisateur si il fait une erreur lors du remplissage du formulaire
  if ($("#lien_a").val() == "" || $("#quantiteDemande_a").val() == "") {
    alert("Un champ ne peut pas être vide !");
    return e;
  }

  // on envoie une requête ajax avec les données entrées par l'utilisateur vers la page PHP
  $.ajax({
    data: {
      tcaracteristiquesproduitsFK: $("#tcaracteristiquesproduitsFK_a").val(),
      lien: $("#lien_a").val(),
      ttechnicienFK: $("#ttechnicienFK_a").val(),
      tplateformeFK: $("#tplateformeFK_a").val(),
      quantiteDemande: $("#quantiteDemande_a").val(),
      reference: $("#reference_a").val(),
      type: 1,
    },
    type: "post",
    url: "../config/besoins-save.php",
    success: function (dataResult) {
      try {
        var dataResult = JSON.parse(dataResult);
      } catch (e) {
        if (e instanceof SyntaxError) {
          alert("Erreur lors de la requête : " + dataResult, true);
        } else {
          alert("Erreur lors de la requête : " + dataResult, false);
        }
      }
      if (dataResult.statusCode == 200) {
        $("#myModalReformeAdd").modal("hide");
        alert("Données correctement ajoutées !");
        document.location.reload();
      } else if (dataResult.statusCode == 201) {
        alert(dataResult);
      }
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

// DELETE
$(document).on("click", ".delete", function () {
  var tbesoinsPK = $(this).attr("data-id");
  var nomFabricant = $(this).attr("data-fabricant");
  var nomModele = $(this).attr("data-modele");
  $("#tbesoinsPK_d").val(tbesoinsPK);

  document.getElementById("afficherAccepterDemande").innerHTML =
    "Accepter la demande de " + nomFabricant + "&nbsp;" + nomModele;
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/besoins-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tbesoinsPK: $("#tbesoinsPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalReformeDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

// REFUS
$(document).on("click", ".refuser", function () {
  var tbesoinsPK = $(this).attr("data-id");
  var nomFabricant = $(this).attr("data-fabricant");
  var nomModele = $(this).attr("data-modele");
  $("#tbesoinsPK_r").val(tbesoinsPK);

  document.getElementById("afficherRefuserDemande").innerHTML =
    "Refuser la demande de " + nomFabricant + "&nbsp;" + nomModele;
});

$(document).on("click", "#refuser", function () {
  $.ajax({
    url: "../config/besoins-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 4,
      tbesoinsPK: $("#tbesoinsPK_r").val(),
    },
    success: function (dataResult) {
      $("#myModalReformeDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
