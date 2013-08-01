<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Inherits the constructor and  magic __get/__set methods
 * from BaseModel
 */
class TinderBox_Section extends TinderBox_BaseModel
{
    public function getContents()
    {
        $contents = $this->connection->get("proposal_sections/list_contents/{$this->id}");
        $content_list = array();
        foreach($contents as $c) {
            $content_list[] = new TinderBox_Content($c->content, $this->connection);
        }
        return $content_list;
    }

    protected function getController()
    {
        return 'proposal_sections';
    }

    protected function getObjectKey()
    {
        return 'proposal_section';
    }
}
