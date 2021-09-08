<?php

require_once('../connect.php');
require('fpdf183/fpdf.php');

class PDF extends FPDF
{
    // caractères spéciaux
    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '')
    {
        parent::Cell($w, $h, utf8_decode($txt), $border, $ln, $align, $fill, $link);
    }

    // En-tête
    function Header()
    {
        // Logo
        $this->Image('../img/crous.png', 10, 6, 30);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(30, 10, 'Réforme', 1, 0, 'C');
        // Saut de ligne
        $this->Ln(20);
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$header = array('Fabricant', 'Modèle', 'Date', 'État de fonctionnement', 'Raison de la réforme', 'Numéro de série');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 7);

$dateDebut = $_GET['dateDebut'];
$dateFin = $_GET['dateFin'];

// Largeurs des colonnes
$w = array(25, 37, 15, 45, 45, 25);

$pdf->Ln();
for ($i = 0; $i < count($header); $i++)
    $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');

$sql = "SELECT nomFabricant, nomModele, DATE(dateReforme), etatFonctionnement, motifReforme, numeroSerie FROM treforme JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = treforme.tcaracteristiquesproduitsFK JOIN tnumerosseries ON tnumerosseries.tnumerosseriesPK=treforme.tnumerosseriesFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE Date(dateReforme) BETWEEN '$dateDebut' AND '$dateFin'";

if ($result = mysqli_query($conn, $sql)) {
    foreach ($result as $row) {
        $i = -1;
        $pdf->Ln();
        foreach ($row as $column) {
            $i++;
            $pdf->Cell($w[$i], 7, $column, 1);
        }
    }
}
$pdf->Output();
