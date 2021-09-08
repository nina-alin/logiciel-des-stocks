// DELETE
$(document).on("click", ".delete", function () {
  var tproduitsstockesPK = $(this).attr("data-id");
  $("#tproduitsstockesPK_d").val(tproduitsstockesPK);

  var nomFabricant = $(this).attr("data-fabricant");
  var nomModele = $(this).attr("data-modele");

  document.getElementById("afficherSupprimerAlerte").innerHTML =
    "Supprimer l'alerte de " + nomFabricant + "&nbsp;" + nomModele;
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/dashboard-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 1,
      tproduitsstockesPK: $("#tproduitsstockesPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalAlertDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Alerte correctement supprimée !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

function dateCles() {
  var date = document.getElementById("dateCles").value;
  $.ajax({
    url: "../config/dashboard-save.php",
    method: "GET",
    data: {
      type: 2,
      dateSortie: date,
    },
    success: function (dataResult) {
      console.log(dataResult);
      $("#produitSortieDate").html(dataResult);
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
}

// DELETE
$(document).on("click", ".deletetype", function () {
  var ttypeproduitsPK = $(this).attr("data-id-type");
  $("#ttypeproduitsPK_d").val(ttypeproduitsPK);

  var nomTypeProduit = $(this).attr("data-nom");

  document.getElementById("afficherSupprimerAlerteTypeProduit").innerHTML =
    "Supprimer l'alerte de " + nomTypeProduit;
});

$(document).on("click", "#delete-type", function () {
  $.ajax({
    url: "../config/dashboard-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      ttypeproduitsPK: $("#ttypeproduitsPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalAlertTypeDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Alerte correctement supprimée !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
