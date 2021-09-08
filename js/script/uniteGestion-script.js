// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#nomUniteGestion").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 1,
      nomUniteGestion: $("#nomUniteGestion").val(),
    },
    type: "post",
    url: "../config/ug-save.php",
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
        $("#myModalUniteGestionAdd").modal("hide");
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
  var tunitegestionPK = $(this).attr("data-id");
  var nomUniteGestion = $(this).attr("data-nom");
  $("#tunitegestionPK_u").val(tunitegestionPK);
  $("#nomUniteGestion_u").val(nomUniteGestion);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomUniteGestion_u").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      tunitegestionPK: $("#tunitegestionPK_u").val(),
      nomUniteGestion: $("#nomUniteGestion_u").val(),
    },
    type: "post",
    url: "../config/ug-save.php",
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
        $("#myModalUniteGestionUpdate").modal("hide");
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
  var tunitegestionPK = $(this).attr("data-id");
  $("#tunitegestionPK_d").val(tunitegestionPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/ug-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tunitegestionPK: $("#tunitegestionPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalUniteGestionDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
