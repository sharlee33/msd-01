<?php

/*
<div class="block size1on2" id="opcvm_sicav">
	<div class="head">
		<img src='/etc/designs/lbp/opcvm/img/long/fcpe.png' alt='FCPE'/>
	</div>
	<div class="body">
		<p>
			<strong>Au </strong><span>13 oct. 2014</span>
			<br />
			<strong>Valeur de la part :</strong>
		</p>
	</div>
	<div class="foot">
		<span class="price">13,73&nbsp; &euro;</span>
		<ul>
		...
		</ul>
	</div>
</div>
*/

function tofloat($num) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
  
    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
}  

// Recup code source HTML de la page web
$url = "https://www.labanquepostale.fr/transversal/opcvm/FR0010431304.0.html";
$html = file_get_contents($url);	
//echo $html; echo "***************************************************";

// Load content
$dom = new DOMDocument;
$dom->loadHTML($html); 

// search <span class="price" ...
$valeur = "not find";
$listeSpans = $dom->getElementsByTagName("span");
foreach($listeSpans as $span)
{
	if ($span->hasAttribute("class")) 
	{
		$class = $span->getAttribute("class");
		if ($class = "price") 
		{
			//$valeur = floatval($span->nodeValue);
			$valeur = tofloat($span->nodeValue);
			echo "$valeur\n";
			//echo "<script type='text/javascript'>alert('$valeur')</script>";
			break;
		}
	}
}

?>
