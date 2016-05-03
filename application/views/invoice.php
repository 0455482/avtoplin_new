<html>
	<head>
		<title>MPDF X.</title>
			<style>
				#headerImg {
					width: 100%;
				}
				#contactData {
					list-style-type: none;
					margin-left: -40px;
				}


			</style>

	</head>

	<body>
		<img id='headerImg' src='images/g1cover.jpg'>
		<p>Spoštovani, </p>
		<p> 
			veseli nas, da ste pokazali zanimanje za predelavo Vašega avtomobila na avtoplin in v predstavitvi prepoznali prednosti, ki jih naša tehnologija ponuja. Prepričani smo, da bomo Vaše zaupanje z avtoplinsko tehnologijo nove generacije tudi upravičili, saj naše sisteme uporablja že več tisoč zadovoljnih uporabnikov.
		</p>
		<p>
			V Vaše vozilo Vam vgradimo tehnologijo <?php echo $motor_name ?>, ki po patentiranem postopku vodi vbrizg avtoplina v realnem času. Tehnologija je plod slovenskega znanja in je zaščitena s svetovnim patentom.
		</p>

		<h2>Zakaj se odločiti za patentirano avtoplinsko tehnologijo <?php echo $motor_name ?>?</h2>

		<ul>
			<li>Patentiran vbrizg avtoplina v realnem času in posledično bistveno nižja poraba goriva in manjša izguba moči.</li>
			<li>Patentirana samonastavljiva krmilna elektronika in tako samodejno nadzorovanje delovanja sistema.</li>
			<li>Brez dodatnih nastavitev map.</li>
			<li><?php echo $guarantee ?></li>
			<li>Lasten razvoj in optimalna tehnična podpora.</li>
			<li>Izjemne cene in plačilni pogoji.</li>
			<li>EKOkreditiranje brez stroškov odobritve, brez obresti, prvi obrok šele naslednji mesec, ko ga plačate kar s prihranki.</li>
			<li>Plačila na položnice, za odobritev potrebna le predložitev osebnega dokumenta in davčne številke.</li>
		</ul>

		<p>
			<b>Predviden čas vgradnje</b> tehnologije <?php echo $motor_name ?> v Vaše vozilo je med <?php echo $work_time ?> ur. Nadomestno vozilo je že všteto v ceno.
		</p>	
		<p>
			Opozoriti Vas moramo, da se lahko poraba avtoplina količinsko minimalno poveča napram porabi bencina, odvisna pa je tudi od letnega časa ter razmerja med butanom in propanom, ki ga točijo na črpalkah. Od mešalnega razmerja je namreč odvisna kalorična vrednost avtoplina.
		</p>
		<p>
			<b>Redna cena vgradnje tehnologije <?php echo $motor_name ?> v Vaše vozilo sicer znaša <?php echo number_format($work_price, 2) ?> €</b>, ker pa Vam v tem obdobju nudimo ekskluzivno promocijsko akcijo, v kateri ste kot imetnik TUŠ klub kartice ob gotovinskem plačilu upravičeni do <b><?php echo $Subvencija ?> € subvencije</b>, lahko cena predelave znaša <b>samo <?php echo number_format($work_price-$Subvencija, 2) ?> €.</b> 	
			<br/>
			<?php echo $fin_price_text ?> Lahko pa si zagotovite še <b>dodatnih <?php echo $DNAR ?> €</b> D*NAR-ja na Vašo TUŠ klub kartico in izjemno ceno predelave Vašega vozila v višini <b><?php echo number_format($work_price-$Subvencija-$DNAR, 2) ?> €</b>. To storite tako, da si našo ponudbo ogleda vsaj 10 vaših prijateljev, ki jih na ogled povabite preko e-maila s pomočjo izpolnjenega obrazca na naši spletni strani.
		</p>
		<p>
			Nudimo Vam <b>financiranje</b> na način EKO kreditiranja, POS terminalov, Diners, American Express ter Lyoness kartic in položnic.
		</p>
		<p>
			<b>EKO kredit NKBM</b> na 24 obrokov je brezobresten in brez stroškov odobritve, plačate samo zavarovanje (2,9 % od vrednosti kredita). V kolikor si pridobite poroka, ste upravičeni tudi do stroška zavarovanja.
		</p>
		<p>
			V primeru <b>obročnega odplačevanja</b> preko NKBM, Diners ali American Express se lahko na izhodiščno ceno prizna <?php echo $NKBM['subsidy'] ?> € subvencije (24 x <?php echo number_format(($work_price-$NKBM['subsidy']) / $NKBM['num_of_installments'], 2) ?> €).
		</p>
		<p>
			V primeru <b>obročnega odplačevanja preko položnic na 24 obrokov</b> (potrebujete le osebni dokument in davčno številko) se na izhodiščno ceno prizna <?php echo $Poloznice_24['subsidy'] ?> € subvencije (24 x <?php echo number_format(($work_price-$Poloznice_24['subsidy']) / $Poloznice_24['num_of_installments'], 2) ?> €). Vozilo mora biti lastniško (ne na leasing).
		</p>
		<p>
			V primeru <b>obročnega odplačevanja preko položnic na 12 obrokov</b> (potrebujete le osebni dokument in davčno številko) se na izhodiščno ceno prizna <?php echo $Poloznice_12['subsidy'] ?> € subvencije (<?php echo $Poloznice_12['deposit'] ?> € pologa + 12 x <?php echo number_format(($work_price-$Poloznice_12['deposit']-$Poloznice_12['subsidy']) / $Poloznice_12['num_of_installments'], 2) ?> €). Vozilo je lahko še v procesu leasing financiranja.
		</p>

		<h2>Z RAZLIKO V CENI GORIVA POKRIJETE OBROK KREDITA. KO TEGA VEČ NI, PREOSTANEK OBDRŽITE VI!</h2>
		<p>
			Za dodatne informacije smo dosegljivi na telefonski številki <b>041 388 893.</b>
		</p>

		<ul id='contactData'>
			<li>Jurij Kerčmar</li>
			<li>G-1 d.o.o.</li>
			<li>Ljubljanska cesta 37</li>
			<li>3000 Celje</li>
			<li>SLOVENIJA</li>
		</ul>

	</body>
</html>"