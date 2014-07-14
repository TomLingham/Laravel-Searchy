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
	protected $fields;

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
	 * @param array $fields
	 */
	public function __construct( $table = null, $fields = [] ){
		$this->fields = $fields;
		$this->table = $table;
	}

	/**
	 * @param $searchString
	 * @return \Illuminate\Database\Query\Builder|mixed|static
	 * @throws \Whoops\Example\Exception
	 */
	public function query( $searchString ){

		if(\Config::get('searchy::sanitize'))
			$this->searchString = $this->sanitize($searchString);

		$results = \DB::table($this->table)
			->select( \DB::raw('*') )
			->addSelect($this->buildSelectQuery( $this->fields ))
			->orderBy(\Config::get('searchy::fieldName'), 'desc')
			->having(\Config::get('searchy::fieldName'),'>', 0);

		return $results;
	}

	/**
	 * @param array $fields
	 * @return array|\Illuminate\Database\Query\Expression
	 */
	protected function buildSelectQuery( array $fields ){
		$query = [];

		foreach ($fields as $field) {
			$query[] = $this->buildSelectCriteria( $field );
		}

		$query = \DB::raw(implode(' + ', $query) . ' AS ' . \Config::get('searchy::fieldName'));

		return $query;
	}

	/**
	 * @param null $field
	 * @return string
	 */
	protected function buildSelectCriteria( $field = null ) {
		$criteria = [];

		foreach( $this->matchers as $matcher => $multiplier){
			$criteria[] = $this->makeMatcher( $field, $matcher, $multiplier );
		}

		return implode(' + ', $criteria);
	}


	/**
	 * @param $field
	 * @param $matcherClass
	 * @param $multiplier
	 * @return mixed
	 */
	protected function makeMatcher( $field, $matcherClass, $multiplier )
	{

		$matcher = new $matcherClass( $multiplier );

		return $matcher->buildQueryString( $field, $this->searchString );

	}

	/**
	 * @param $searchString
	 * @return mixed
	 */
	private function sanitize( $searchString ) {
		return preg_replace(\Config::get('searchy::sanitizeRegEx'), '', $searchString);
	}

}