<?php

namespace App\Controller;

use App\Repository\PortableEqipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portable-equipment")
 */
class PortableEqipmentController extends AbstractController
{
    /**
     * @Route("/", name="portable_eqipment_index", methods={"GET"})
     */
    public function index(PortableEqipmentRepository $portableEqipmentRepository): Response
    {
        return $this->render('portable_eqipment/index.html.twig', [
            'portable_eqipments' => $portableEqipmentRepository->findAll(),
        ]);
    }
}
