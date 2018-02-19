<?php $this->assign('title', __("FAQ")); ?>

<DIV class="col-md-12">
	<H1>F.A.Q.</H1>
</DIV>
<DIV class="col-md-6">
<?php if (LG == "nl") { ?>
	<H2>Wat is een 'weggeefplek'?</H2>
	<P>Een weggeefplek is een plaats waar personen voorwerpen plaatsen die ze  kwijt willen. Ze geven deze weg zonder hiervoor geld te vragen.
Anderzijds kunnen personen de weggeefplek bezoeken voor voorwerpen die hen interesseren."</P>
<?php } else { ?>
	<H2>Qu'est-ce qu'une donnerie ?</H2>
	<P>Une donnerie est un endroit où des gens laissent en dép&ocirc;t des objets dont ils veulent se débarrasser. Ils les laissent, sans attendre de l'argent en retour.</P>
	<P>&Agrave; contrario, les gens peuvent visiter la donnerie et emporter les objets qui leur plaisent.</P>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Hoeveel advertenties mag ik posten?</H2>
	<P>Zoveel u zelf wil! Hoe meer advertenties u online zet, hoe dynamischer onze website wordt. 
	Vergeet echter niet om uw advertenties te verwijderen als uw voorwerp een nieuwe eigenaar gevonden heeft. </P>
<?php } else { ?>
	<H2>Combien d'annonces puis-je poster&nbsp;?</H2>
	<P>Autant que vous voulez ! Au plus vous en postez, au plus notre site sera vivant. Toutefois, n'oubliez pas de retirer les annonces dont les objets ont trouvé acquéreur.</P>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Wat betekent de gekleurde band op elke afbeelding?</H2>
	<P>Deze band herneemt de categorie van het voorwerp (tuin, kledij, elektro,…) op een achtergrondkleur:</P>
	<UL>
		<LI><SPAN class="item-state new">groen</SPAN> : in uitstekende toestand, als nieuw;</LI>
		<LI><SPAN class="item-state used">oranje</SPAN> : nauwelijks gebruikt, gebruikt maar werkt nog goed;</LI>
		<LI><SPAN class="item-state broken">rood</SPAN> : bedenkelijke staat, voor reservestukken of om te herstellen.</LI>
	</UL>
<?php } else { ?>
	<H2>Que signifie le bandeau de couleur sur la photo de chaque annonce&nbsp;?</H2>
	<P>Le bandeau reprend la catégorie de l'objet (jardin, vêtement, électroménager...), sur un fond de couleur : </P>
	<UL>
		<LI><SPAN class="item-state new">vert</SPAN> : en excellent état, comme neuf, à peine utilisé;</LI>
		<LI><SPAN class="item-state used">orange</SPAN> : usagé mais remplit sa mission;</LI>
		<LI><SPAN class="item-state broken">rouge</SPAN> : état médiocre, pour les pièces ou à réparer.</LI>
	</UL>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Waarom moet men zijn straat opgeven tijdens de inschrijving?</H2> 
	<P>Deze site beperkt zich tot een gemeente.</P>
	<P>Via uw straat weten we dat u in Jette woont of werkt. We gaan deze informatie niet controleren, maar andere gebruikers kunnen het melden indien u geen link heeft met de gemeente. </P>
	<P>Deze website bestrijkt uw wijk niet? Lanceer deze website voor uw eigen omgeving. Contacteer ons rechts onderaan. </P>
<?php } else { ?>
	<H2>Pourquoi doit-on indiquer sa rue lors de l'inscription ?</H2>
	<P>Le site limite son utilisation à une localité.</P>
	<P>Le choix de votre rue permet de nous assurer que vous habitez ou travaillez dans notre commune. Nous n'allons pas vérifier l'information, mais vous pourriez faire l'objet de plaintes d'autres utilisateurs du site s'il se révélait que vous êtes sans lien avec la commune.</P>
	<P>Vous n'êtes pas dans le quartier couvert par ce site ? Initiez donc l'installation de ce site pour votre communauté : Contact, en bas à droite.</P>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Kunnen we op de hoogte gebracht worden van nieuwe advertenties?</H2> 
	<P>Nee: dit zou teveel lijken op een oude mailinglist, een oud systeem dat wij net willen vermijden. </P>
	<P>Surf regelmatig naar onze website zoals u een rommelmarkt bezoekt. Op de onthaalpagina vindt u de meest recente advertenties.</P>
<?php } else { ?>
	<H2>Peut-on être averti des nouvelles annonces ?</H2>
	<P>Non : cela s'apparentrait à une liste de distribution (<EM>mailinglist</EM>), l'ancien système de donnerie virtuelle que nous voulons justement oublier.</P>
	<P>Visitez régulièrement notre site tout comme vous iriez à une brocante. Avec l'avantage de découvrir en tête de page les dernières offres.</P>
<?php } ?>
</DIV>
<DIV class="col-md-6">
<?php if (LG == "nl") { ?>
	<H2>Waarom zou ik het gratis weggeven als ik het ook kan verkopen? </H2>
	<P>Voor verschillende redenen:</P>
	<OL>
		<LI>U engageert zich niet voor een gegeven voorwerp, de nieuwe eigenaar neemt dit over in de huidige staat.</LI>
		<LI>Daarom moet u ook niet kunnen aantonen dat het voorwerp nog werkt, de onderdelen controleren, ...</LI>
		<LI>U zal uw voorwerp sneller kwijt geraken.</LI>
		<LI>En bovendien, geven doet deugd!</LI>
	</OL>
<?php } else { ?>
	<H2>Pourquoi donnerais-je plutôt que vendre ?</H2>
	<P>Pour de nombreux avantages :</P>
	<OL>
		<LI>Vous n'avez aucun engagement envers l'objet donné, son nouvel acquéreur le prend en l'état.</LI>
		<LI>En conséquence du point 1, vous n'êtes pas tenu de prouver le bon fonctionnement de l'objet, de vérifier les pièces, etc. : le don peut donc se dérouler en dehors de chez vous.</LI>
		<LI>Vous serez plus vite débarrass&eacute; de votre objet.</LI>
		<LI>Et puis, donner est tellement gratifiant !</LI>
	</OL>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Waarom hebben sommige advertenties een witte titel op een grijze achtergrond?</H2>
	<P>Dit zijn zoekertjes: u bent op zoek naar vb autobanden voor een sculptuur, naar bokalen voor confituur, verhuisdozen,...? Plaats dan een advertentie 'Ik zoek...'</P>
<?php } else { ?>
	<H2>Pourquoi certaines annonces ont un titre blanc sur fond gris&nbsp;?</H2>
	<P>Il s'agit de demandes : vous récupérez des pneus pour en faire des sculptures, vous cherchez après des bocaux pour vos confitures, ou vous avez besoin de cartons pour déménager ? Postez une annonce de type "Je cherche"...</P>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Kan ik de advertenties van een specifiek persoon bekijken? </H2>
	<P>Indirect wel: klik eerst op een van zijn/haar advertenties. 
	Als u vervolgens bij de details van de advertentie kijkt, ziet u het pseudoniem van de adverteerder (link). Klik hierop en u ontdekt al zijn/haar advertenties.</P>
<?php } else { ?>
	<H2>Puis-je voir les annonces d'une personne en particulier&nbsp;?</H2>
	<P>Oui, de manière indirecte : cliquez d'abord sur une de ses annonces. Vous êtes dans le détail de l'annonce, et le pseudodyme de l'annonceur est un lien. Cliquez dessus : vous voyez toutes ses annonces.</P>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Kan ik de advertenties uit een bepaalde categorie bekijken?</H2>
	<P>Indirect wel, op voorwaarde dat er minstens 1 advertentie is voor de door u gekozen categorie.</P>
	<P>Als u naar de details van een advertentie kijkt, kan u op de categorie klikken om alle advertenties binnen deze categorie te bekijken.</P>
<?php } else { ?>
	<H2>Puis-je voir les annonces d'une catégorie en particulier&nbsp;?</H2>
	<P>Oui, de manière indirecte, et pour autant qu'il existe au moins une annonce dans la catégorie qui vous intéresse.</P>
	<P>Quand vous êtes dans le détail d'une annonce, sa catégorie est un lien : cliquez dessus pour voir toutes les annonces de cette catégorie.</P>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Waarom verschijnen sommige advertenties met een blauwe ster?</H2>
	<P><IMG src="<?= $this->Url->build("/img/item-same-street.png") ?>">Deze advertenties werden geplaatst door een bewoner van uw straat. Een buur dus!</P>
	<P>Opgelet, deze sterren zijn enkel zichtbaar als u zich aangelogd hebt op de website...</P>
<?php } else { ?>
	<H2>Pourquoi certaines annonces apparaissent avec une étoile bleue ?</H2>
	<P><IMG src="<?= $this->Url->build("/img/item-same-street.png") ?>"> Ces annonces sont postées par un habitant de votre rue. Donc, un voisin !</P>
	<P>Attention, ces étoiles ne peuvent apparaître que si vous êtes identifié sur le site...</P>
<?php } ?>
<?php if (LG == "nl") { ?>
	<H2>Waarom hebben sommige adverteerders een foto en anderen niet?</H2>
	<P>We werken via de <A href="https://nl.gravatar.com/" target="_blank">onlinedienst Gravatar</A> om een foto te vinden die gelinkt is aan uw mailadres. U kan zich dus bij Gravatar inschrijven om uw foto op onze website toe te voegen.</P>
	<P>Deze gratis dienst wordt door duizenden websites gebruikt. U zal dus overal dezelfde avatar terugvinden. En voor ons vereenvoudigt dit het gebruik van uw profiel.</P>
<?php } else { ?>
	<H2>Pourquoi certaines personnes ont leur photo et moi pas ?</H2>
	<P>Nous utilisons <A href="https://fr.gravatar.com/" target="_blank">le service en ligne Gravatar</A> pour trouver la photo attachée à votre adresse email. Vous devez donc vous inscrire sur Gravatar pour avoir votre photo sur notre site.</P>
	<P>Ce service, gratuit, est utilisé par des milliers de sites web. Votre avantage est de retrouver la même photo (souvent appelée "avatar") sur les sites utilisant Gravatar, et le nôtre est de simplifier la gestion de votre profil.</P>
<?php } ?>
</DIV>