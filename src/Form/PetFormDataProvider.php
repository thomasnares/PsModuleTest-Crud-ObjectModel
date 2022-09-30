<?php

namespace Preston\CustomerPetList\Form;

use Preston\CustomerPetList\Entity\Pet;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;
use PrestaShopObjectNotFoundException;

final class PetFormDataProvider implements FormDataProviderInterface
{
    /**
     * Get form data for given object with given id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getData($petId)
    {
        $petObjectModel = new Pet($petId);

        // check that the element exists in db
        if (empty($petObjectModel->id)) {
            throw new PrestaShopObjectNotFoundException('Object not found');
        }

        return [
            'name' => $petObjectModel->name,
            'breed' => $petObjectModel->breed,
        ];
    }

    /**
     * Get default form data.
     *
     * @return mixed
     */
    public function getDefaultData()
    {
        return [
            'name' => '',
            'breed' => ''
        ];
    }
}