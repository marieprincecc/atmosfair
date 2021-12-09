<?php 

namespace App\Search;

class SearchProduct
{
private $filterByName;

private $filterByRooms;

public function getFilterByName()
{
return $this->filterByName;
}

public function setFilterByName($filterByName)
{
$this->filterByName = $filterByName;
return $this;
}

public function getFilterByRooms()
{
return $this->filterByRooms;
}

public function setFilterByRooms($filterByRooms)
{
$this->filterByRooms = $filterByRooms;
return $this;
}

public function getFilterByPolluting()
{
return $this->filterByPolluting;
}

public function setFilterByPolluting($filterByPolluting)
{
$this->filterByPolluting = $filterByPolluting;
return $this;
}

}


?> 