<?php

namespace Preston\CustomerPetList\Form;

use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;
use Preston\CustomerPetList\Entity\Pet;

final class PetFormDataHandler implements FormDataHandlerInterface
{
    /**
     * Create object from form data.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        $petObjectModel = new Pet();

        foreach($data as $key => $value){
            $petObjectModel->$key = $value;
        }

        $petObjectModel->save();

        return $petObjectModel->id;
    }

    /**
     * Update object with form data.
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $petObjectModel = new Pet($id);
        
        foreach($data as $key => $value){
            $petObjectModel->$key = $value;
        }

        $petObjectModel->setFieldsToUpdate(["name" => true]);
        $petObjectModel->save();

    }
}