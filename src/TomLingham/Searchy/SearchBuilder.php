<?php namespace TomLingham\Searchy;


use Illuminate\Support\Facades\Config;
use TomLingham\Searchy\SearchDrivers\FuzzySearchDriver;

/**
 * @property mixed driverName
 */
class SearchBuilder {


	private $table;
	private $searchFields;
	private $driverName;

	/**
	 * @param $table
	 * @return $this
	 */
	public function search( $table )
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * @return FuzzySearchDriver
	 */
	public function fields( /* $fields */ )
	{

		$searchFields = func_get_args();

		$this->searchFields = $searchFields;

		return $this->makeDriver();

	}

	/**
	 * @param $driverName
	 * @return $this
	 */
	public function driver( $driverName )
	{
		$this->driverName = $driverName;
		return $this;
	}

	/**
	 * @param $table
	 * @param $fields
	 * @return mixed
	 */
	public function __call( $table, $fields )
	{

		return call_user_func_array([$this->search( $table ), 'fields'], $fields);

	}

	/**
	 * @return mixed
	 */
	private function makeDriver()
	{
		if (! $this->driverName){
			$driverName = \Config::get('searchy::default');
		} else {
			$driverName = $this->driverName;
		}
		$driverMap = \Config::get("searchy::drivers.$driverName");

		return new $driverMap['class']( $this->table, $this->searchFields );

	}

}