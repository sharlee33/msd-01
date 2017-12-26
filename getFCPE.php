<?php

/* OUTPUT example
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

201712 :
<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-4">
	    <div class="opcvm-summary">
	      <p class="opcvm-summary__date">
			Au 21 DÉCEMBRE 2017
	      </p>
	      <p class="opcvm-summary__value">
	        <span>Actif net global</span>
	        <span>
	            113,51 M€
	        </span>
	        </p>
	      <p class="opcvm-summary__value">
	        <span>Valeur liquidative</span>
	        <span>
	            15,61 €
	        </span>
	      </p>
	    </div>
	</div>
--> à modifier
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

// Desactivamos los posibles warning para que no se envien los headers
error_reporting(0);

// Recup code source HTML de la page web
// ACTIONS 30 EUROPE
$url30Eur = "https://www.labanquepostale.fr/transversal/opcvm/FR0010431304.0.html";
// ACTIONS 70 SOLIDAIRE
$url70Sol = "https://www.labanquepostale.fr/transversal/opcvm/FR0011057363.0.html";
// init url suivant param
switch ($_GET['action']) {
    case "30Eur":
        $url =  $url30Eur;
        break;
    case "70Sol":
        $url =  $url70Sol;
        break;
    default:
        echo "unknown action";
}
$html = file_get_contents($url);	

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
