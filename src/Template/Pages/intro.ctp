<?php $this->assign('title', __("Introduction")); ?>

<DIV class="col-md-12">
	<?php if (LG == "nl") { ?>
	<H1>Wat is deze website?</H1>
	<?php } else { ?>
	<H1>C'est quoi ce site ?</H1>
	<?php } ?>
</DIV>
<DIV class="col-md-5">
	<?php if (LG == "nl") { ?>
	<H2>Een weggeefplek…</H2>
	<P>Een weggeefplek is een plaats waar men objecten en voorwerpen kan plaatsen die men niet langer nodig heeft. Deze voorwerpen worden gratis weggegeven, er gebeurt geen betaling.</P>
	<?php } else { ?>
	<H2>Une donnerie...</H2>
	<P>Une donnerie est un espace où les gens déposent des objets dont ils n'ont plus besoin. Ces objets sont à donner : il n'y a pas de transaction d'argent.</P>
	<?php } ?>
	<?php if (LG == "nl") { ?>
	<H2>... virtueel...</H2>
	<P>Op deze website kan u voorwerpen wegschenken: u plaatst een advertentie en wacht tot geïnteresseerden contact opnemen met u.</P>
	<?php } else { ?>
	<H2>... virtuelle...</H2>
	<P>Ce site est un espace où vous pouvez donner des objets : vous postez des annonces, et attendez que des personnes intéressées vous contactent.</P>
	<?php } ?>
	<?php if (LG == "nl") { ?>
	<H2>... lokaal...</H2>
	<P>Om deze weggeefplek optimaal te laten werken, moet het een lokaal initiatief blijven. Zou u België of zelfs Brussel doorkruisen om een boek op te pikken? Nee! En de eigenaar zal het gratis voorwerp evenmin opsturen.  Maar zou u enkele straten verder een boek gaan oppikken? Zeker wel!</P>
	<P>Deze website richt zich dus op de bewoners van Jette en op personen die in Jette werken.</P>
	<?php } else { ?>
	<H2>... locale</H2>
	<P>Pour que cela fonctionne, le site doit rester local : traverserez-vous la Belgique, voire  Bruxelles, pour un livre à donner&nbsp;? Non&nbsp;! Et son propriétaire ne vous l'enverra pas.<BR>
    Mais irez-vous quelques rues plus loin pour ce livre&nbsp;? Certainement&nbsp;!</P>
	<P>Ce site s'adresse donc aux habitants et travailleurs de Jette.</P>
	<?php } ?>
</DIV>
<DIV class="col-md-7">
	<?php if (LG == "nl") { ?>
	<H2>Een voorbeeldadvertentie</H2>
	<IMG src="<?= $this->Url->build("/img/voorbeeldadvertentie.png") ?>" class="img-fluid">
	<?php } else { ?>
	<H2>Une annonce en un coup d'oeil</H2>
	<IMG src="<?= $this->Url->build("/img/annonce-legendes.png") ?>" class="img-fluid">
	<?php } ?>
</DIV>
