// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#nomTypeProduit").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 1,
      nomTypeProduit: $("#nomTypeProduit").val(),
    },
    type: "post",
    url: "../config/typeProduits-save.php",
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
        $("#myModalTypeProduitAdd").modal("hide");
        alert("Données ajoutées avec succès !");
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

// UPDATE
$(document).on("click", ".update", function (e) {
  var ttypeproduitsPK = $(this).attr("data-id");
  var nomTypeProduit = $(this).attr("data-nom");
  var alerte = $(this).attr("data-alerte");

  document.getElementById("afficherUpdateNomTypeProduit").innerHTML =
    "Modifier " + nomTypeProduit;
    
  $("#ttypeproduitsPK_u").val(ttypeproduitsPK);
  $("#nomTypeProduit_u").val(nomTypeProduit);
  $("#alerte_u").val(alerte);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomTypeProduit_u").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      ttypeproduitsPK: $("#ttypeproduitsPK_u").val(),
      nomTypeProduit: $("#nomTypeProduit_u").val(),
      alerte: $('input[name="alerte_u"]:checked').val(),
    },
    type: "post",
    url: "../config/typeProduits-save.php",
    success: function (dataResult) {
      console.log(dataResult);
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
        $("#myModalTypeProduitUpdate").modal("hide");
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

// DELETE
$(document).on("click", ".delete", function () {
  var ttypeproduitsPK = $(this).attr("data-id");
  $("#ttypeproduitsPK_d").val(ttypeproduitsPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/typeProduits-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      ttypeproduitsPK: $("#ttypeproduitsPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalTypeProduitDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

// GET
$(document).on("click", ".view", function (e) {
  var ttypeproduitsPK = $(this).attr("data-id");
  var nomTypeProduit = $(this).attr("data-nom");

  document.getElementById("afficherNomTypeProduit").innerHTML =
    "Liste des produits de type " + nomTypeProduit;

  $.ajax({
    url: "../config/typeProduits-save.php",
    method: "GET",
    data: {
      type: 4,
      ttypeproduitsPK: ttypeproduitsPK,
    },
    success: function (dataResult) {
      $("#typeProduits_details").html(dataResult);
      $("#myModalTypeProduitView").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
