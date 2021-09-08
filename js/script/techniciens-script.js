// POST
$(document).on("click", "#btn-add", function (e) {
  if (
    $("#nomTechnicien").val() == "" ||
    $("#prenomTechnicien").val() == "" ||
    $("#fonction").val() == ""
  ) {
    alert("Un champ ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 1,
      nomTechnicien: $("#nomTechnicien").val(),
      prenomTechnicien: $("#prenomTechnicien").val(),
      fonction: $("#fonction").val(),
      toujoursService: $('input[name="toujoursService_a"]:checked').val(),
    },
    type: "post",
    url: "../config/technicien-save.php",
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
        $("#myModalTechnicienAdd").modal("hide");
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
  var ttechnicienPK = $(this).attr("data-id");
  var nomTechnicien = $(this).attr("data-nom");
  var prenomTechnicien = $(this).attr("data-prenom");
  var fonction = $(this).attr("data-fonction");
  var toujoursService = $(this).attr("data-service");
  $("#ttechnicienPK_u").val(ttechnicienPK);
  $("#nomTechnicien_u").val(nomTechnicien);
  $("#prenomTechnicien_u").val(prenomTechnicien);
  $("#fonction_u").val(fonction);
  $("#toujoursService_u").val(toujoursService);
});

$(document).on("click", "#update", function (e) {
  if (
    $("#nomTechnicien_u").val() == "" ||
    $("#prenomTechnicien_u").val() == "" ||
    $("#fonction_u").val() == ""
  ) {
    alert("Un champ ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      ttechnicienPK: $("#ttechnicienPK_u").val(),
      nomTechnicien: $("#nomTechnicien_u").val(),
      prenomTechnicien: $("#prenomTechnicien_u").val(),
      fonction: $("#fonction_u").val(),
      toujoursService: $('input[name="toujoursService_u"]:checked').val(),
    },
    type: "post",
    url: "../config/technicien-save.php",
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
        $("#myModalTechnicienUpdate").modal("hide");
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
  var ttechnicienPK = $(this).attr("data-id");
  $("#ttechnicienPK_d").val(ttechnicienPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/technicien-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      ttechnicienPK: $("#ttechnicienPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalTechnicienDelete").modal("hide");
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
  var ttechnicienPK = $(this).attr("data-id");
  var nomTechnicien = $(this).attr("data-nom");
  var prenomTechnicien = $(this).attr("data-prenom");
  document.getElementById("afficherViewTechnicien").innerHTML =
    "Produits ajoutés par " + prenomTechnicien + " " + nomTechnicien;
  $.ajax({
    url: "../config/technicien-save.php",
    method: "GET",
    data: {
      type: 4,
      ttechnicienPK: ttechnicienPK,
    },
    success: function (dataResult) {
      $("#technicien_details").html(dataResult);
      $("#myModalTechnicienView").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
