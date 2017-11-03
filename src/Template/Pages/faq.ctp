<?php $this->assign('title', __("FAQ")); ?>

<DIV class="col-md-12">
	<H1>F.A.Q.</H1>
</DIV>
<DIV class="col-md-6">
	<H2>Qu'est-ce qu'une donnerie ?</H2>
	<P>Une donnerie est un endroit où des gens laissent en dép&ocirc;t des objets dont ils veulent se débarrasser. Ils les laissent, sans attendre de l'argent en retour.</P>
	<P>&Agrave; contrario, les gens peuvent visiter la donnerie et emporter les objets qui leur plaisent.</P>
	<H2>Combien d'annonces puis-je poster&nbsp;?</H2>
	<P>Autant que vous voulez ! Au plus vous en postez, au plus notre site sera vivant. Toutefois, n'oubliez pas de retirer les annonces dont les objets ont trouvé acquéreur.</P>
	<H2>Que signifie le bandeau de couleur sur la photo de chaque annonce&nbsp;?</H2>
	<P>Le bandeau reprend la catégorie de l'objet (jardin, vêtement, électroménager...), sur un fond de couleur : </P>
	<UL>
		<LI><SPAN class="item-state new">vert</SPAN> : en excellent état, comme neuf, à peine utilisé;</LI>
		<LI><SPAN class="item-state used">orange</SPAN> : usagé mais remplit sa mission;</LI>
		<LI><SPAN class="item-state broken">rouge</SPAN> : état médiocre, pour les pièces ou à réparer.</LI>
	</UL>
	<H2>Pourquoi doit-on indiquer sa rue lors de l'inscription ?</H2>
	<P>Le site limite son <A href="<?= $this->Url->build("/pages/info") ?>" title="En voici la raison">utilisation à une localité</A>.</P>
	<P>Le choix de votre rue permet de nous assurer que vous habitez ou travaillez dans notre commune. Nous n'allons pas vérifier l'information, mais vous pourriez faire l'objet de plaintes d'autres utilisateurs du site s'il se révélait que vous êtes sans lien avec la commune.</P>
	<P>Vous n'êtes pas dans le quartier couvert par ce site ? Initiez donc l'installation de ce site pour votre communauté : Contact, en bas à droite.</P>
	<H2>Peut-on être averti des nouvelles annonces ?</H2>
	<P>Non : cela s'apparentrait à une liste de distribution (<EM>mailinglist</EM>), l'ancien système de donnerie virtuelle que nous voulons justement oublier.</P>
	<P>Visitez régulièrement notre site tout comme vous iriez à une brocante. Avec l'avantage de découvrir en tête de page les dernières offres.</P>
	<!--
	<H2>Le site s'adressant aux gens de ma commune, puis-je malgré tout partager mon annonce dans les réseaux sociaux&nbsp;?</H2>
	<P>Bien sûr, vous pouvez !</P>
	-->
</DIV>
<DIV class="col-md-6">
	<H2>Pourquoi donnerais-je plutôt que vendre ?</H2>
	<P>Pour de nombreux avantages :</P>
	<OL>
		<LI>Vous n'avez aucun engagement envers l'objet donné, son nouvel acquéreur le prend en l'état.</LI>
		<LI>En conséquence du point 1, vous n'êtes pas tenu de prouver le bon fonctionnement de l'objet, de vérifier les pièces, etc. : le don peut donc se dérouler en dehors de chez vous.</LI>
		<LI>Vous serez plus vite débarrass&eacute; de votre objet.</LI>
		<LI>Et puis, donner est tellement gratifiant !</LI>
	</OL>
	<H2>Pourquoi certaines annonces ont un titre blanc sur fond gris&nbsp;?</H2>
	<P>Il s'agit de demandes : vous récupérez des pneus pour en faire des sculptures, vous cherchez après des bocaux pour vos confitures, ou vous avez besoin de cartons pour déménager ? Postez une annonce de type "Je cherche"...</P>
	<H2>Puis-je voir les annonces d'une personne en particulier&nbsp;?</H2>
	<P>Oui, de manière indirecte : cliquez d'abord sur une de ses annonces. Vous êtes dans le détail de l'annonce, et le pseudodyme de l'annonceur est un lien. Cliquez dessus : vous voyez toutes ses annonces.</P>
	<H2>Puis-je voir les annonces d'une catégorie en particulier&nbsp;?</H2>
	<P>Oui, de manière indirecte, et pour autant qu'il existe au moins une annonce dans la catégorie qui vous intéresse.</P>
	<P>Quand vous êtes dans le détail d'une annonce, sa catégorie est un lien : cliquez dessus pour voir toutes les annonces de cette catégorie.</P>
	<H2>Pourquoi certaines annonces apparaissent avec une étoile bleue ?</H2>
	<P><IMG src="<?= $this->Url->build("img/item-same-street.png") ?>"> Ces annonces sont postées par un habitant de votre rue. Donc, un voisin !</P>
	<P>Attention, ces étoiles ne peuvent apparaître que si vous êtes identifié sur le site...</P>
	<H2>Pourquoi certaines personnes ont leur photo et moi pas ?</H2>
	<P>Nous utilisons <A href="https://fr.gravatar.com/" target="_blank">le service en ligne Gravatar</A> pour trouver la photo attachée à votre adresse email. Vous devez donc vous inscrire sur Gravatar pour avoir votre photo sur notre site.</P>
	<P>Ce service, gratuit, est utilisé par des milliers de sites web. Votre avantage est de retrouver la même photo (souvent appelée "avatar") sur les sites utilisant Gravatar, et le nôtre est de simplifier la gestion de votre profil.</P>
</DIV>