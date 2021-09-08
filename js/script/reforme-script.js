var GlobaltnumerosseriesFK;

// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#tnumerosseriesFK_a").val() == undefined) {
    alert(
      "Merci de sélectionner un numéro de série dans la liste. Pour en ajouter de nouveaux, rendez-vous dans la page stocks."
    );
    return e;
  }
  $.ajax({
    data: {
      tnumerosseriesFK: $("#tnumerosseriesFK_a").val(),
      etatFonctionnement: $("#etatFonctionnement_a").val(),
      motifReforme: $("#motifReforme_a").val(),
      ttechnicienFK: $("#ttechnicienFK_a").val(),
      tcaracteristiquesproduitsFK: $("#tcaracteristiquesproduitsFK_a").val(),
      type: 1,
    },
    type: "post",
    url: "../config/reforme-save.php",
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
  var treformePK = $(this).attr("data-id");
  var tcaracteristiquesproduitsFK = $(this).attr("data-id-caracteristiques");
  var etatFonctionnement = $(this).attr("data-fonctionnement");
  var ttechnicienFK = $(this).attr("data-id-caracteristiques");
  var tnumerosseriesFK = $(this).attr("data-numero");
  var motifReforme = $(this).attr("data-reforme");
  $("#treformePK_u").val(treformePK);
  $("#tcaracteristiquesproduitsFK_u").val(tcaracteristiquesproduitsFK);
  $("#etatFonctionnement_u").val(etatFonctionnement);
  $("#ttechnicienFK_u").val(ttechnicienFK);
  $("#tnumerosseriesFK_u").val(tnumerosseriesFK);
  $("#motifReforme_u").val(motifReforme);
});

$(document).on("click", "#update", function (e) {
  if ($("#tnumerosseriesFK_u").val() == undefined) {
    alert(
      "Merci de sélectionner un numéro de série dans la liste. Pour en ajouter de nouveaux, rendez-vous dans la page stocks."
    );
    return e;
  }
  $.ajax({
    data: {
      treformePK: $("#treformePK_u").val(),
      tcaracteristiquesproduitsFK: $("#tcaracteristiquesproduitsFK_u").val(),
      etatFonctionnement: $("#etatFonctionnement_u").val(),
      ttechnicienFK: $("#ttechnicienFK_u").val(),
      tnumerosseriesFK: $("#tnumerosseriesFK_u").val(),
      motifReforme: $("#motifReforme_u").val(),
      type: 2,
    },
    type: "post",
    url: "../config/reforme-save.php",
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
        $("#myModalReformeUpdate").modal("hide");
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
  var treformePK = $(this).attr("data-id");
  $("#treformePK_d").val(treformePK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/reforme-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      treformePK: $("#treformePK_d").val(),
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

function changerGlobalId_Add() {
  GlobaltnumerosseriesFK = $("#tcaracteristiquesproduitsFK_a").val();
  $.ajax({
    url: "../config/reforme-save.php",
    method: "GET",
    data: {
      type: 4,
      tcaracteristiquesproduitsFK: GlobaltnumerosseriesFK,
    },
    success: function (dataResult) {
      $("#showNumeroSerie_Add").html(dataResult);
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
}

function changerGlobalId_Update() {
  GlobaltnumerosseriesFK = $("#tcaracteristiquesproduitsFK_u").val();
  $.ajax({
    url: "../config/reforme-save.php",
    method: "GET",
    data: {
      type: 5,
      tcaracteristiquesproduitsFK: GlobaltnumerosseriesFK,
    },
    success: function (dataResult) {
      $("#showNumeroSerie_Update").html(dataResult);
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
}

// GET
$(document).on("click", "#export", function (e) {
  var dateDebut = $("#dateDebut").val();
  var dateFin = $("#dateFin").val();
  if (dateDebut == "" || dateFin == "") {
    alert("Merci de sélectionner des dates !");
    return e;
  } else if (dateDebut > dateFin) {
    alert("La date de fin doit être ultérieure à la date de début !");
    return e;
  }
  window.open(
    "https://logicieldesstocks.crous-lille.fr/libs/export-pdf.php?dateDebut=" +
      dateDebut +
      "&dateFin=" +
      dateFin
  );
});
