<?php

namespace App\Controller;

use App\Repository\PortableEqipmentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portable-equipment/type")
 */
class PortableEqipmentTypeController extends AbstractController
{
    /**
     * @Route("/", name="portable_eqipment_type_index", methods={"GET"})
     */
    public function index(PortableEqipmentTypeRepository $portableEqipmentTypeRepository): Response
    {
        return $this->render('portable_eqipment_type/index.html.twig', [
            'portable_eqipment_types' => $portableEqipmentTypeRepository->findAll(),
        ]);
    }

}
