<?php
function suppr_accents($str, $encoding='utf-8')
{
	// transformer les caractères accentués en entités HTML
	$str = htmlentities($str, ENT_NOQUOTES, $encoding);
	
	// remplacer les entités HTML pour avoir juste le premier caractères non accentués
	// Exemple : "&ecute;" => "e", "&Ecute;" => "E", "Ã " => "a" ...
	$str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	
	// Remplacer les ligatures tel que : Œ, Æ ...
	// Exemple "Å“" => "oe"
	$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
	
	return $str;
}
?>