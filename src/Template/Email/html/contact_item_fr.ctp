<P>Bonjour <?= $owner ?>,</P>
<P><strong><?= $applicant ?></strong> (<?= $email ?>) est intéressé par votre annonce <A href="<?= $item_link ?>"><?= $item_title ?></A>. Voici son message :</P>
<P><strong><I><?= $message ?></I></strong></P>
<P>Réagissez :</P>
<UL>
	<LI>Envoyez-lui une réponse en répondant à cet email.</LI>
	<LI>Si ce contact semble prometteur, <A href="<?= $item_book ?>">indiquez que votre annonce est réservée</A>.</LI>
	<LI>Si votre annonce n'est plus d'actualité, <A href="<?= $item_delete ?>">supprimez-la</A> !</LI>
</UL>