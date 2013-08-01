<?php
require_once __DIR__ . '/BaseModel.php';

/**
 * Inherits the constructor and  magic __get/__set methods
 * from BaseModel
 */
class TinderBox_Content extends TinderBox_BaseModel
{

    protected function getController()
    {
        return 'proposal_contents';
    }

    protected function getObjectKey()
    {
        return 'proposal_content';
    }
}
