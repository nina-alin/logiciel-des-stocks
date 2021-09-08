// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#nomLibelle_a").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      nomLibelle: $("#nomLibelle_a").val(),
      templacementsFK: $("#templacementsFK_a").val(),
      type: 1,
    },
    type: "post",
    url: "../config/libelle-save.php",
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
        $("#myModalLibelleAdd").modal("hide");
        alert("Données correctement ajoutées !");
        location.reload();
      } else if (dataResult.statusCode == 201) {
        alert(dataResult);
      }
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

$(document).on("click", ".update", function (e) {
  var tlibellesPK = $(this).attr("data-libelle-id");
  var templacementsFK = $(this).attr("data-emplacement-id");
  var nomLibelle = $(this).attr("data-nom-libelle");
  document.getElementById("afficherUpdateNomLibelle").innerHTML =
    "Modifier le libellé " + nomLibelle;
  $("#tlibellesPK_u").val(tlibellesPK);
  $("#templacementsFK_u").val(templacementsFK);
  $("#nomLibelle_u").val(nomLibelle);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomLibelle_u").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      tlibellesPK: $("#tlibellesPK_u").val(),
      nomLibelle: $("#nomLibelle_u").val(),
      templacementsFK: $("#templacementsFK_u").val(),
      type: 2,
    },
    type: "post",
    url: "../config/libelle-save.php",
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
        $("#editLibelleModal").modal("hide");
        alert("Données correctement modifiées !");
        location.reload();
      } else if (dataResult.statusCode == 201) {
        alert(dataResult);
      }
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

$(document).on("click", ".delete", function () {
  var tlibellesPK = $(this).attr("data-id");
  $("#tlibellesPK_d").val(tlibellesPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/libelle-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tlibellesPK: $("#tlibellesPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalLibelleDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

// GET
$(document).on("click", ".view", function (e) {
  var tlibellesPK = $(this).attr("data-id");
  var nomLibelle = $(this).attr("data-nom-libelle");
  var nomEmplacement = $(this).attr("data-nom-emplacement");
  document.getElementById("afficherViewNomLibelle").innerHTML =
    "Liste des produits situés dans " + nomEmplacement + " - " + nomLibelle;
  $.ajax({
    url: "../config/libelle-save.php",
    method: "GET",
    data: {
      type: 4,
      tlibellesPK: tlibellesPK,
    },
    success: function (dataResult) {
      $("#libelle_details").html(dataResult);
      $("#myModalLibelleView").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
