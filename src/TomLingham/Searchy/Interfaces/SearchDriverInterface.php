<?php namespace TomLingham\Searchy\Interfaces;

interface SearchDriverInterface
{
	/**
	 * Execute the query on the Driver
	 *
	 * @param $searchString
	 * @return mixed
	 */
	public function query( $searchString );

}