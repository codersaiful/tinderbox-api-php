<?php
require __DIR__ . '/../lib/TinderBox.php';

$options["debug"] = false;
$options["protocol"] = "http";

$hostname = "my.domain.com";
$api_key = "123456";

$tinderbox = new TinderBox($hostname, $api_key, $options);

# Fetch Proposals, Sections, Contents with individual calls.
$result = $tinderbox->getProposals($stdClass = true);

foreach ($result as $proposal) {

	if ($proposal->proposal->id == 412) {
		$sections = $tinderbox->getProposalSections($proposal->proposal->id);

		$section = $sections[0];
		$contents = $tinderbox->getProposalSectionContents($section->section->id);

		foreach ($contents as $content) {
			echo $content->content->body . "\n";
		}
	}

}

