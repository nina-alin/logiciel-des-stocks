// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#nomFabricant").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 1,
      nomFabricant: $("#nomFabricant").val(),
    },
    type: "post",
    url: "../config/fabricants-save.php",
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
        $("#myModalFabricantsAdd").modal("hide");
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
  var tfabricantsPK = $(this).attr("data-id");
  var nomFabricant = $(this).attr("data-nom");
  $("#tfabricantsPK_u").val(tfabricantsPK);
  $("#nomFabricant_u").val(nomFabricant);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomFabricant_u").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      tfabricantsPK: $("#tfabricantsPK_u").val(),
      nomFabricant: $("#nomFabricant_u").val(),
    },
    type: "post",
    url: "../config/fabricants-save.php",
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
        $("#myModalFabricantsUpdate").modal("hide");
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
  var tfabricantsPK = $(this).attr("data-id");
  $("#tfabricantsPK_d").val(tfabricantsPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/fabricants-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tfabricantsPK: $("#tfabricantsPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalFabricantsDelete").modal("hide");
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
  var tfabricantsPK = $(this).attr("data-id");
  var nomFabricant = $(this).attr("data-nom");
  document.getElementById("afficherNomFabricant").innerHTML =
    "Liste des produits du fabricant " + nomFabricant;
  $.ajax({
    url: "../config/fabricants-save.php",
    method: "GET",
    data: {
      type: 4,
      tfabricantsPK: tfabricantsPK,
    },
    success: function (dataResult) {
      $("#fabricants_details").html(dataResult);
      $("#myModalFabricantsView").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
