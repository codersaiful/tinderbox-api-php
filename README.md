# PHP - TinderBox REST API

This PHP library uses CURL to communicate with TinderBox's REST API (JSON).
Currently supports v1 of our API and has a limited feature set.

See examples folder for code samples.

Usage:

    $tinderbox = new TinderBox($hostname, $api_key);

	// Returns Array of stdClass objects from json_decode
	$proposals = $tinderbox->proposals();

	// Returns Array of TinderBox_Proposal objects.
	$proposals = $tinderbox->proposals($stdClass=false);


## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
