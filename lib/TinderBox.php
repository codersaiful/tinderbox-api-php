<?php
require __DIR__ . '/TinderBox/Proposal.php';
require __DIR__ . '/TinderBox/Section.php';
require __DIR__ . '/TinderBox/Content.php';

/**
 * This is a quick wrapper for the TinderBox v1 REST API
 * It supports a minimal amount of methods as a starting point.
 */ 
class TinderBox
{

    private $api_key;
    private $hostname;
    private $options;
    private $protocol;

    public function __construct($hostname, $api_key, $options=array())
    {
        $this->hostname = $hostname;
        $this->api_key = $api_key;
        $this->options = $options;
        $this->protocol = isset($options["protocol"]) ? $options["protocol"] : "https";
    }

    public function getProposals($json_objects=true)
    {
        $this->log("Fetching proposals...");
        $json_proposals = $this->get('proposals');

        # Give option for results to be returned as TinderBox Objects.
        if ($json_objects == false) {
            $proposal_list = array();
            foreach ($json_proposals as $p) {
                $proposal_list[] = new TinderBox_Proposal($p->proposal, $this);
            }
        }

        return $json_objects ? $json_proposals : $proposal_list;
    }

    public function getProposal($id, $stdClass=false)
    {
        $this->log("Fetching proposal $id");
        $json_proposal = $this->get("proposals/{$id}");
        if ($stdClass == true) {
            return $json_proposal->proposal;
        }

        return new TinderBox_Proposal($json_proposal->proposal, $this);
    }

    # Returns a TinderBox_Proposal object to be populated and then saved.
    public function newProposal($data=array())
    {
        return new TinderBox_Proposal($data, $this);
    }

    # Sample/Base method for creating a proposal from associative array.
    public function createProposal($data)
    {
        return $this->post('proposals', array("proposal" => $data));
    }

    # Sample/Base method for deleting a proposal
    public function deleteProposal($id)
    {
        return $this->delete("proposals/$id");
    }
    
    # Sample/Base method for retrieving sections for a proposal.
    public function getProposalSections($proposal_id)
    {
        return $this->get("proposals/list_sections/{$proposal_id}");
    }

    # Sample/Base method for retrieving contents from a section.
    public function getProposalSectionContents($proposal_section_id)
    {
        return $this->get("proposal_sections/list_contents/{$proposal_section_id}");
    }

    public function get($path, $data=false)
    {
        $this->log("GET Request for $path with $data");
        return json_decode($this->callAPI("GET", $path, $data));
    }

    public function post($path, $data=false)
    {
        $this->log("POST Request for $path with $data");
        return json_decode($this->callAPI("POST", $path, $data));
    }

    public function delete($path)
    {
        $this->log("DELETE Request for $path");
        return $this->callAPI("DELETE", $path);
    }

    // Method: POST, PUT, GET etc
    // Data: array("param" => "value") ==> index.php?param=value

    protected function callAPI($method, $path, $data = false)
    {
        // Create base URL to work from.
        $url = sprintf("%s://%s/%s.json?api_key=%s", $this->protocol, $this->hostname, $path, $this->api_key);
        $this->log("Default URL: $url");
        $curl = curl_init();

        $options = array(
            CURLOPT_RETURNTRANSFER   => true,
            CURLOPT_HTTPHEADER       => array('Content-type: application/json')
        );

        curl_setopt_array( $curl, $options );

        switch (strtoupper($method))
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:  # GET
                if ($data)
                    $url = sprintf("%s&%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $this->log("Final URL: $url");

        $response = curl_exec($curl);

        $this->log("CURL Response: $response");

        return $response;
    }

    protected function log($message)
    {
        if (is_array($this->options) && $this->options["debug"] == true) {
            print $message . "\n";
        }
    }
}
