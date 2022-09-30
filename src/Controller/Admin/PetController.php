<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
declare(strict_types=1);

namespace Preston\CustomerPetList\Controller\Admin;

use Preston\CustomerPetList\Grid\Definition\Factory\ProductGridDefinitionFactory;
use Preston\CustomerPetList\Grid\Filters\PetFilters;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PetController extends FrameworkBundleAdminController
{
    const TAB_CLASS_NAME = 'CustomerPetListControllerTab';

    /**
     * @AdminSecurity("is_granted('read', 'CustomerPetListControllerTab')")
     *
     * @param PetFilters $filters
     * 
     * @return Response
     */
    public function indexAction(PetFilters $filters)
    {
        $quoteGridFactory = $this->get('preston.customerPetList.grid.factory.pets');
        $quoteGrid = $quoteGridFactory->getGrid($filters);

        return $this->render(
            '@Modules/customerpetlist/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Pet listing', 'Modules.CustomerPetList.Admin'),
                'quoteGrid' => $this->presentGrid($quoteGrid),
            ]
        );
    }

    /**
     * @AdminSecurity("is_granted('read', 'CustomerPetListControllerTab')")
     *
     * @param int $petId
     * 
     * @return Response
     */
    public function editAction(int $petId, Request $request)
    {
        
        $petFormBuilder = $this->get('preston.customerPetList.form.pet_form_builder');
        $petForm = $petFormBuilder->getFormFor($petId);

        
        $petForm->handleRequest($request);

        $petFormHandler = $this->get('preston.customerPetList.form.pet_form_handler');
        $result = $petFormHandler->handleFor($petId, $petForm);

        if ($result->isSubmitted() && $result->isValid()) {
            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('preston_customerpetlist_controller_index');
        }

        return $this->render(
            '@Modules/customerpetlist/views/templates/admin/edit.html.twig',
            [
                'petForm' => $petForm->createView()
            ]
        );
    }
}
