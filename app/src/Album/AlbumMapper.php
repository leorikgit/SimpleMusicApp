<?php
namespace Album;
use Database\Adapter\AdapterI;

class AlbumMapper implements AlbumMapperI{
    private $_adapter;

    public function __construct(AdapterI $source)
    {
        $this->_adapter = $source;
    }
    public function find($id)
    {
        $sql = "SELECT * FROM albums WHERE id=?";
        return $this->_adapter->find($sql, $id);
    }
    public function create($data)
    {
        // TODO: Implement create() method.
    }
    public function query($sql, $one, $params)
    {
        $result =  $this->_adapter->query($sql, $params);

        if($result->getError()){
            throw new \Exception('Something goes wrong');
        }
        if($one){
            return $result =  $this->_adapter->query($sql, $params)->getResult();
        }
        return $this->_adapter->query($sql, $params)->getResults();
    }
}
