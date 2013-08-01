<?php

abstract class TinderBox_BaseModel
{
    protected $data;
    protected $connection;

    public function __construct($data, $connection=null)
    {
        if (is_array($data)) {
            $this->data = $data;
        } else if ($data instanceof stdClass) {
            $this->data = get_object_vars($data);
        } else {
            throw new InvalidArgumentException("Data must be an array or stdClass");
        }

        if ($connection) {
            $this->connection = $connection;
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function save()
    {
        $response = $this->connection->post($this->getController(), array($this->getObjectKey() => $this->data));
        if ($response->proposal) {
            # Re-assign instance data after save in case of new proposal.
            $this->data = get_object_vars($response->proposal);
            return true;
        }
        return false;
    }

    public function destroy()
    {
        $id = $this->data["id"];
        if (is_numeric($id) && $id) {
            return $this->connection->delete($this->getController() . "/{$id}");
        }
        throw new RuntimeException("Instance without an id cannot be deleted.");
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    abstract protected function getController();

    abstract protected function getObjectKey();
}

