<?php
require __DIR__ . '/../lib/TinderBox.php';

$hostname = "my.domain.com";
$api_key = "123456";

$options["debug"] = true;
$options["protocol"] = "http";

$tinderbox = new TinderBox($hostname, $api_key, $options);

print "Create Proposal From Associative Array.\n";
$data = array(
	"name" => "API Proposal",
	"client" => "API Client",
	"description" => "API Description",
);

print_r($tinderbox->createProposal($data));

print "\n\n";

print "Create using TinderBox_Proposal object.\n";

$proposal = $tinderbox->newProposal();
$proposal->name = "Proposal Name";
$proposal->client = "Proposal Client";
$proposal->description = "Proposal Description";
print_r($proposal->save());

