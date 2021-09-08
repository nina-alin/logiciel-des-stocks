// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#nomModele_a").val() == "") {
    alert("Le nom du modèle ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      nomModele: $("#nomModele_a").val(),
      compatibilite: $("#compatibilite_a").val(),
      ttypeproduitsFK: $("#ttypeproduitsFK_a").val(),
      tfabricantsFK: $("#tfabricantsFK_a").val(),
      tlibellesFK: $("#tlibellesFK_a").val(),
      type: 1,
    },
    type: "post",
    url: "../config/caracteristiquesProduits-save.php",
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

// UPDATE
$(document).on("click", ".update", function (e) {
  var tcaracteristiquesproduitsPK = $(this).attr("data-id");
  var tfabricantsFK = $(this).attr("data-id-fabricant");
  var ttypeproduitsFK = $(this).attr("data-id-typeproduit");
  var compatibilite = $(this).attr("data-compatibilite");
  var nomModele = $(this).attr("data-nom-modele");

  var nomFabricant = $(this).attr("data-nom-fabricant");

  document.getElementById("afficherUpdateCaracteristiquesProduits").innerHTML =
    "Modifier " + nomFabricant + "&nbsp;" + nomModele;

  $("#tcaracteristiquesproduitsPK_u").val(tcaracteristiquesproduitsPK);
  $("#tfabricantsFK_u").val(tfabricantsFK);
  $("#nomModele_u").val(nomModele);
  $("#ttypeproduitsFK_u").val(ttypeproduitsFK);
  $("#compatibilite_u").val(compatibilite);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomModele_u").val() == "") {
    alert("Le nom du modèle ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      tcaracteristiquesproduitsPK: $("#tcaracteristiquesproduitsPK_u").val(),
      tfabricantsFK: $("#tfabricantsFK_u").val(),
      nomModele: $("#nomModele_u").val(),
      ttypeproduitsFK: $("#ttypeproduitsFK_u").val(),
      compatibilite: $("#compatibilite_u").val(),
    },
    type: "post",
    url: "../config/caracteristiquesProduits-save.php",
    success: function (dataResult) {
      try {
        var dataResult = JSON.parse(dataResult);
      } catch (e) {
        if (e instanceof SyntaxError) {
          alert(dataResult, true);
        } else {
          alert(dataResult, false);
        }
      }
      if (dataResult.statusCode == 200) {
        $("#myModalCaracteristiquesProduitsUpdate").modal("hide");
        alert("Données correctement modifiées !");
        document.location.reload();
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
  var tcaracteristiquesproduitsPK = $(this).attr("data-id");
  $("#tcaracteristiquesproduitsPK_d").val(tcaracteristiquesproduitsPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/caracteristiquesProduits-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tcaracteristiquesproduitsPK: $("#tcaracteristiquesproduitsPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalCaracteristiquesProduitsDelete").modal("hide");
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
    type: "GET",
    data: {
      type: 4,
      ttypeproduitsPK: ttypeproduitsPK,
    },
    url: "../config/typeProduits-save.php",
    success: function (resultat) {},
    error: function (request, status, error) {
      alert(request.responseText);
    },
    complete: function (resultat, statut) {},
  });
});
