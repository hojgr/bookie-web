<?php


namespace BookieGG\Contracts\Repositories;

use BookieGG\Models\ImageType;
use BookieGG\Models\Organization;
use BookieGG\Models\OrganizationImage;

interface OrganizationRepositoryInterface {
	/**
	 * Creates a new Organization
	 *
	 * @param $name
	 * @param $url
	 * @return Organization
	 */
	public function create($name, $url);

	public function save(Organization $o, OrganizationImage $oi, ImageType $it);

	public function getAll();

	public function delete(Organization $organization);

	public function findById($id);
}