<P>Hallo <?= $owner ?>,</P>
<P><strong><?= $applicant ?></strong> (<?= $email ?>) is geïnteresseerd in uw advertentie <A href="<?= $item_link ?>"><?= $item_title ?></A>. Ziehier zijn/haar bericht: 
<P><strong><I><?= $message ?></I></strong></P>
<P>Reageer :</P>
<UL>
	<LI>Stuur een antwoord  via deze e-mail.</LI>
	<LI>Als dit contact veelbelovend lijkt, <A href="<?= $item_book ?>">geef dan aan dat uw advertentie gereserveerd is</A>.</LI>
	<LI>Als uw advertentie niet meer relevant is, <A href="<?= $item_delete ?>">verwijder ze dan</A> !</LI>
</UL>