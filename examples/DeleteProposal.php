<?php
require __DIR__ . '/../lib/TinderBox.php';

$options["debug"] = true;
$options["protocol"] = "http";

$hostname = "my.domain.com";
$api_key = "123456";

$tinderbox = new TinderBox($hostname, $api_key, $options);

print "Create using TinderBox_Proposal object.\n";

$proposal = $tinderbox->newProposal();
$proposal->name = "Proposal Name";
$proposal->client = "Proposal Client";
$proposal->description = "Proposal Description";

$proposal->save();

print_r($proposal);

print "Destroying proposal: " . $proposal->id . "\n";

print_r($proposal->destroy());

