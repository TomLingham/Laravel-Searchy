<?php

namespace TomLingham\Searchy;

use Illuminate\Config\Repository;
use TomLingham\Searchy\SearchDrivers\FuzzySearchDriver;

/**
 * @property mixed driverName
 */
class SearchBuilder
{
    /**
     * @var
     */
    private $table;

    /**
     * @var
     */
    private $searchFields;

    /**
     * @var
     */
    private $driverName;

    /**
     * @var
     */
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * @param $searchable
     *
     * @return $this
     */
    public function search($searchable)
    {
        // Check if table name or Eloquent
        $isEloquent = is_object($searchable) && method_exists($searchable, 'getTable');

        $this->table = $isEloquent ? $searchable->getTable() : $searchable;

        return $this;
    }

    /**
     * @return FuzzySearchDriver
     */
    public function fields(/* $fields */)
    {
        $args = func_get_args();

        $this->searchFields = is_array( $args[0] ) ? $args[0] : $args;

        return $this->makeDriver();
    }

    /**
     * @param $driverName
     *
     * @return $this
     */
    public function driver($driverName)
    {
        $this->driverName = $driverName;

        return $this;
    }

    /**
     * @param $table
     * @param $searchFields
     *
     * @return mixed
     */
    public function __call($table, $searchFields)
    {
        return call_user_func_array([$this->search($table), 'fields'], $searchFields);
    }

    /**
     * @return mixed
     */
    private function makeDriver()
    {
        $relevanceFieldName = $this->config->get('searchy.fieldName');

        // Check if default driver is being overridden, otherwise
        // load the default
        $driverName = $this->driverName ? $this->driverName : $this->config->get('searchy.default');

        // Gets the details for the selected driver from the configuration file
        $driver = $this->config->get("searchy.drivers.$driverName")['class'];

        // Create a new instance of the selected drivers 'class' and pass
        // through table and fields to search
        $driverInstance = new $driver( $this->table,
                                       $this->searchFields,
                                       $relevanceFieldName,
                                       ['*']);

        return $driverInstance;
    }
}
