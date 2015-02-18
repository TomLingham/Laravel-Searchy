<?php namespace TomLingham\Searchy;

use Illuminate\Config\Repository;
use TomLingham\Searchy\SearchDrivers\FuzzySearchDriver;


/**
 * @property mixed driverName
 */
class SearchBuilder {


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


	private $config;

	public function __construct( Repository $config )
	{
		$this->config = $config;
	}

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
	 * @param $searchFields
	 * @return mixed
	 */
	public function __call( $table, $searchFields )
	{

		return call_user_func_array([$this->search( $table ), 'fields'], $searchFields);

	}

	/**
	 * @return mixed
	 */
	private function makeDriver()
	{

		// Check if default driver is being overridden, otherwise
		// load the default
		if ( $this->driverName ){
			$driverName = $this->driverName;
		} else {
			$driverName = $this->config->get('searchy.default');
		}

		// Gets the details for the selected driver from the configuration file
		$driverMap = $this->config->get("searchy.drivers.$driverName");

		// Create a new instance of the selected drivers 'class' and pass
		// through table and fields to search
		return new $driverMap['class']( $this->table, $this->searchFields );

	}

}