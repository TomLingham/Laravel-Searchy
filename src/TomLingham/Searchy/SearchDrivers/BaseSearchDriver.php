<?php namespace TomLingham\Searchy\SearchDrivers;

use TomLingham\Searchy\Interfaces\SearchDriverInterface;

/**
 * @property mixed methods
 * @property mixed matchers
 */
abstract class BaseSearchDriver implements SearchDriverInterface {

	/**
	 * @var array
	 */
	protected $searchFields;

	/**
	 * @var
	 */
	protected $searchString;

	/**
	 * @var null
	 */
	protected $table;

	/**
	 * @param null $table
	 * @param array $searchFields
	 */
	public function __construct( $table = null, $searchFields = [] )
	{
		$this->searchFields = $searchFields;
		$this->table = $table;
	}

	/**
	 * @param $searchString
	 * @return \Illuminate\Database\Query\Builder|mixed|static
	 * @throws \Whoops\Example\Exception
	 */
	public function query( $searchString )
	{

		if(\Config::get('searchy::sanitize'))
			$this->searchString = $this->sanitize($searchString);

		$results = \DB::table($this->table)
			->select('*')
			->addSelect($this->buildSelectQuery( $this->searchFields ))
			->orderBy(\Config::get('searchy::fieldName'), 'desc')
			->having(\Config::get('searchy::fieldName'),'>', 0);

		return $results;
	}

	/**
	 * @param array $searchFields
	 * @return array|\Illuminate\Database\Query\Expression
	 */
	protected function buildSelectQuery( array $searchFields )
	{

		$query = [];

		foreach ($searchFields as $searchField) {
			$query[] = $this->buildSelectCriteria( $searchField );
		}

		$query = \DB::raw(implode(' + ', $query) . ' AS ' . \Config::get('searchy::fieldName'));

		return $query;
	}

	/**
	 * @param null $searchField
	 * @return string
	 */
	protected function buildSelectCriteria( $searchField = null )
	{

		$criteria = [];

		foreach( $this->matchers as $matcher => $multiplier){
			$criteria[] = $this->makeMatcher( $searchField, $matcher, $multiplier );
		}

		return implode(' + ', $criteria);
	}


	/**
	 * @param $searchField
	 * @param $matcherClass
	 * @param $multiplier
	 * @return mixed
	 */
	protected function makeMatcher( $searchField, $matcherClass, $multiplier )
	{

		$matcher = new $matcherClass( $multiplier );

		return $matcher->buildQueryString( $searchField, $this->searchString );

	}

	/**
	 * @param $searchString
	 * @return mixed
	 */
	private function sanitize( $searchString )
	{
		return preg_replace(\Config::get('searchy::sanitizeRegEx'), '', $searchString);
	}

}