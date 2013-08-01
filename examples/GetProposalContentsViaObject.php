<?php
require __DIR__ . '/../lib/TinderBox.php';

$options["debug"] = false;
$options["protocol"] = "http";

$hostname = "my.domain.com";
$api_key = "123456";


$tinderbox = new TinderBox($hostname, $api_key, $options);

# Fetch Sections and Contents from their respective objects.

$proposal = $tinderbox->getProposal(412);
$sections = $proposal->getSections();
$contents = $sections[0]->getContents();

foreach ($contents as $c) {
	print $c->body . "\n";
}
