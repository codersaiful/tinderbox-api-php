<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Inherits the constructor and  magic __get/__set methods
 * from BaseModel
 */
class TinderBox_Proposal extends TinderBox_BaseModel
{
    public function getSections()
    {
        $sections = $this->connection->get("proposals/list_sections/{$this->id}");
        $section_list = array();
        foreach ($sections as $s) {
            $section_list[] = new TinderBox_Section($s->section, $this->connection);
        }
        return $section_list;
    }

    protected function getController()
    {
        return 'proposals';
    }

    protected function getObjectKey()
    {
        return 'proposal';
    }

}
