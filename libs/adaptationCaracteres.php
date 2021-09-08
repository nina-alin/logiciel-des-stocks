<?php
function suppr_accents($str, $encoding='utf-8')
{
	// transformer les caract�res accentu�s en entit�s HTML
	$str = htmlentities($str, ENT_NOQUOTES, $encoding);
	
	// remplacer les entit�s HTML pour avoir juste le premier caract�res non accentu�s
	// Exemple : "&ecute;" => "e", "&Ecute;" => "E", "� " => "a" ...
	$str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	
	// Remplacer les ligatures tel que : �, � ...
	// Exemple "œ" => "oe"
	$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
	
	return $str;
}
?>