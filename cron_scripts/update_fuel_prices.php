<?php
	include_once('../resources/htmlDOMphp/simple_html_dom.php');
	$html     = file_get_html('http://www.petrol.si/');
	$divBox   = $html->find('div[id=block-gas-prices-front-gasprices-frontpage]', 0);
	$conn = new mysqli('109.123.4.55', 'root', 'P0t3nc1a123!', 'avtoplin');  // servername, username, password, dbname
	foreach ($divBox->find('span') as $span)
		$names[] = $span->plaintext;
	foreach ($divBox->find('strong') as $strong)
		$prices[] = $strong->plaintext;
	
	for ($i=0; $i<count($prices); $i++)
		$array[$names[$i]] = $prices[$i];

	$query = 'UPDATE avtoplin.fuel 
			  SET price = CASE 
			  	WHEN name = "Q Max 100 " 	THEN "'.str_replace(",", ".", $array['Q Max 100 ']).'" 
			  	WHEN name = "Q Max 95 " 	THEN "'.str_replace(",", ".", $array['Q Max 95 ']).'"
			  	WHEN name = "Q Max diesel " THEN "'.str_replace(",", ".", $array['Q Max diesel ']).'" 
			  	WHEN name = "Kurilno olje " THEN "'.str_replace(",", ".", $array['Kurilno olje ']).'" 
			  	WHEN name = "Q Max LPG " 	THEN "'.str_replace(",", ".", $array['Q Max LPG ']).'"
			  END';
	
	$result = $conn->query($query);
	if ($result) {
		return 1;
	} else {
		return 0;
	}
	$conn->close();
?>