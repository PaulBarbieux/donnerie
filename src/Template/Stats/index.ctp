<?php
// Group stats by user
$users = array();
$cntItems = 0;
foreach ($stats as $stat) {
	if (!isset($users[$stat->user_id])) {
		$users[$stat->user_id]['tot_items'] = 0;
		$users[$stat->user_id]['tot_contacts'] = 0;
	}
	$users[$stat->user_id]['items'][$stat->item_id]['contacts'] = $stat->contacts;
	$users[$stat->user_id]['tot_items']++;
	$users[$stat->user_id]['tot_contacts'] += $stat->contacts;
	$cntItems++;
}
// Best announcers
$bestUsers = array();
foreach ($users as $userId => $user) {
	$bestUsers[$user['tot_items']][$userId] = $user['tot_contacts'];
}
krsort($bestUsers);
// Stats by month
$years = array();
foreach ($stats as $stat) {
	$yyyy = $stat->created->year;
	$mm = $stat->created->month;
	if (!isset($years[$yyyy]['sum'])) {
		$years[$yyyy]['sum'] = 0;
	}
	if (!isset($years[$yyyy][$mm])) {
		$years[$yyyy][$mm] = 0;
	}
	$years[$yyyy][$mm]++;
	$years[$yyyy]['sum']++;
}
?>
<div class="col-sm-12">
    <H1><?= __('Statistiques') ?></H1>
</div>
<div class="col-sm-12">
	<DIV class="card">
		<DIV class="card-header">
			<H2 class="card-title">Annonces par mois</H2>
		</DIV>
		<DIV class="card-body">
			<TABLE class="table">
				<THEAD>
					<TR>
						<TH>&nbsp;</TH>
						<?php for ($mm = 1; $mm <= 12; $mm++) { ?>
						<TH class="text-right"><?= $mm ?></TH>
						<?php } ?>
						<TH class="text-right">Total année</TH>
					</TR>
				</THEAD>
				<TBODY>
					<?php foreach ($years as $yyyy => $months) { ?>
					<TR>
						<TH class="text-right"><?= $yyyy ?></TH>
						<?php for ($mm = 1; $mm <= 12; $mm++) { ?>
						<TD class="text-right">
						<?php if (isset($months[$mm])) print $months[$mm]; ?>
						</TD>
						<?php } ?>
						<TD class="text-right"><?= $months['sum'] ?></TD>
					</TR>
					<?php } ?>
				</TBODY>
			</TABLE>
		</DIV>
	</DIV>
	<P>&nbsp;</P>
</div>
<div class="col-sm-12 col-md-5 col-lg-6">
	<DIV class="card">
		<DIV class="card-header">
			<H2 class="card-title">Quelques chiffres</H2>
		</DIV>
		<DIV class="card-body">
			<TABLE class="table">
				<TR>
					<TH>Utilisateurs inscrits
						<BR><small class="text-muted">Tous les utilisateurs, même non confirmés.</small></TH>
					<TD class="text-right"><?= $countAllUsers ?></TD>
				</TR>
				<TR>
					<TH>Utilisateurs non confirmés
						<BR><small class="text-muted">Utilisateurs n'ayant pas confirmé leur inscription, ou bannis.</small></TH>
					<TD class="text-right"><?= $countUnregisteredUsers ?></TD>
				</TR>
				<TR>
					<TH>Annonceurs
						<BR><small class="text-muted">Utilisateurs ayant posté au moins une annonce.</small></TH>
					<TD class="text-right"><?= count($users) ?></TD>
				</TR>
				<TR>
					<TH>Annonces déjà postées
						<BR><small class="text-muted">Nombre d'annonces depuis le début du site.</small></TH>
					<TD class="text-right"><?= $cntItems ?></TD>
				</TR>
				<TR>
					<TH>Annonces en cours
						<BR><small class="text-muted">Annonces actuellement affichées.</small></TH>
					<TD class="text-right"><?= $countCurrentItems ?></TD>
				</TR>
			</TABLE>
		</DIV>
	</DIV>
</div>
<div class="col-sm-12 col-md-7 col-lg-6">
	<DIV class="card">
		<DIV class="card-header">
			<H2 class="card-title">Annonceurs les plus actifs</H2>
		</DIV>
		<DIV class="card-body">
			<TABLE class="table table-striped">
				<THEAD>
					<TR>
						<TH scope="col">Id annonceur
						<BR><small class="text-muted">Identifiant de l'utilisateur.</small></TH>
						<TH scope="col">Nombre d'annonces
						<BR><small class="text-muted">Nombre d'annonces par utilisateur.</small></TH>
						<TH scope="col">Nombre de contacts
						<BR><small class="text-muted">Total de contacts pour l'ensemble de ses annonces.</small></TH>
					</TR>
				</THEAD>
				<TBODY>
					<?php
					$cntBest = 0;
					foreach ($bestUsers as $totItems => $users) {
						foreach ($users as $userId => $totContacts) {
							$cntBest++;
					?>
					<TR>
						<TD><?= $this->Html->link($userId, ['controller' => 'Items', 'action' => 'user', $userId] , ['title' => __("Voir ses annonces")]) ?></TD>
						<TD><?= $totItems ?></TD>
						<TD><?= $totContacts ?></TD>
					</tr>
					<?php
						}
						if ($cntBest > 15) {
							break;
						}
					}
					?>
				</TBODY>
			</TABLE>
		</DIV>
	</DIV>
</div>