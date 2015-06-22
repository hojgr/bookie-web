<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Models\ImageType;
use BookieGG\Models\Organization;
use BookieGG\Models\OrganizationImage;

class OrganizationRepository implements OrganizationRepositoryInterface {

    /**
     * Creates a new Organization
     *
     * @param $name
     * @param $url
     * @return Organization
     */
    public function create($name, $url)
    {
        $org = new Organization(['name' => $name, 'url' => $url]);
        $org->save();
        return $org;
    }

    public function getAll()
    {
        return Organization::all();
    }

    public function delete(Organization $organization) {
        return $organization->delete();
    }

    public function findById($id)
    {
        return Organization::find($id);
    }

    public function save(Organization $o, OrganizationImage $oi, ImageType $it)
    {
        $o->save();

        $oi->image_type_id = $it->id;

        $o->images()->save($oi);
    }
}