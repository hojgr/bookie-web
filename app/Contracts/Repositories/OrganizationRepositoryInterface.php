<?php


namespace BookieGG\Contracts\Repositories;

use BookieGG\Models\Organization;

interface OrganizationRepositoryInterface {
	/**
	 * Creates a new Organization
	 *
	 * @param $name
	 * @param $url
	 * @return Organization
	 */
	public function create($name, $url);

	public function getAll();

	public function delete(Organization $organization);

	public function findById($id);
}