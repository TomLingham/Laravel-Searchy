<?php

namespace TomLingham\Searchy\SearchDrivers;

use Illuminate\Support\Facades\Schema;
use TomLingham\Searchy\Interfaces\SearchDriverInterface;

abstract class BaseSearchDriver implements SearchDriverInterface
{
    protected $table;

    protected $columns;

    protected $searchFields;

    protected $searchString;

    protected $relevanceFieldName;

    protected $query;

    protected $withTrashed;

    /**
     * @param null  $table
     * @param array $searchFields
     * @param $relevanceFieldName
     * @param array $columns
     *
     * @internal param $relevanceField
     */
    public function __construct($table = null, $searchFields = [], $relevanceFieldName, $columns = ['*'])
    {
        $this->searchFields = $searchFields;
        $this->table = $table;
        $this->columns = $columns;
        $this->relevanceFieldName = $relevanceFieldName;
    }


    /**
     * Specify whether to return soft deleted items or not
     *
     * @return $this
     */
    public function withTrashed()
    {
        $this->withTrashed = true;

        return $this;
    }


    /**
     * Specify which columns to return.
     *
     * @return $this
     */
    public function select()
    {
        $this->columns = func_get_args();

        return $this;
    }

    /**
     * Specify the string that is is being searched for.
     *
     * @param $searchString
     *
     * @return \Illuminate\Database\Query\Builder|mixed|static
     */
    public function query($searchString)
    {
        $this->searchString = substr(\DB::connection()->getPdo()->quote($searchString), 1, -1);

        return $this;
    }

    /**
     * Get the results of the search as an Array.
     *
     * @return array
     */
    public function get()
    {
        return $this->run()->get();
    }

    /**
     * Returns an instance of the Laravel Fluent Database Query Object with the search
     * queries applied.
     *
     * @return array
     */
    public function getQuery()
    {
        return $this->run();
    }

    /**
     * Runs the 'having' method directly on the Laravel Fluent Database Query Object
     * and returns the instance of the object.
     *
     * @return mixed
     */
    public function having()
    {
        return call_user_func_array([$this->run(), 'having'], func_get_args());
    }

    /**
     * @return $this
     */
    protected function run()
    {
        $this->query = \DB::table($this->table)
            ->select($this->columns)
            ->addSelect($this->buildSelectQuery($this->searchFields));

        // If they included withTrashed flag then give them all records including soft deletes
        // Check to ensure the column exists before committing
        if( ! $this->withTrashed && in_array('deleted_at', Schema::getColumnListing($this->table)) )
            $this->query = $this->query->where('deleted_at', NULL);

        return $this->query
            ->orderBy($this->relevanceFieldName, 'desc')
            ->having($this->relevanceFieldName, '>', 0);
    }

    /**
     * @param array $searchFields
     *
     * @return array|\Illuminate\Database\Query\Expression
     */
    protected function buildSelectQuery(array $searchFields)
    {
        $query = [];

        foreach ($searchFields as $searchField) {
            if (strpos($searchField, '::')) {

                $concatString = implode(', ', array_map( [$this, 'sanitizeColumnName'] , explode('::', $searchField)));

                $query[] = $this->buildSelectCriteria("CONCAT({$concatString})");
            } else {
                $query[] = $this->buildSelectCriteria($this->sanitizeColumnName($searchField));
            }
        }

        return \DB::raw( implode(' + ', $query) . ' AS ' . $this->relevanceFieldName);
    }


    /**
     * Sanitize column names to prevent collisions with MySQL reserved words
     *
     * @param $name
     * @return string
     */
    protected function sanitizeColumnName($name)
    {
        $name = str_replace('.', '`.`', trim($name, '` '));

        return "`${name}`";
    }


    /**
     * @param null $searchField
     *
     * @return string
     */
    protected function buildSelectCriteria($searchField = null)
    {
        $criteria = [];

        foreach ($this->matchers as $matcher => $multiplier) {
            $criteria[] = $this->makeMatcher($searchField, $matcher, $multiplier);
        }

        return implode(' + ', $criteria);
    }

    /**
     * @param $searchField
     * @param $matcherClass
     * @param $multiplier
     *
     * @return mixed
     */
    protected function makeMatcher($searchField, $matcherClass, $multiplier)
    {
        $matcher = new $matcherClass($multiplier);

        return $matcher->buildQueryString($this->coalesce($searchField), $this->searchString);
    }

    private function coalesce($field)
    {
      return "COALESCE($field, '')";
    }
}
