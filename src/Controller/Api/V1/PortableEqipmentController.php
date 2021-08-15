<?php

namespace App\Controller\Api\V1;

use App\Entity\PortableEqipment;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as Codes;


class PortableEqipmentController extends AbstractFOSRestController
{
    /**
     * list all Portable equipments
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Codes
     */
    public function index(Request $request, PaginatorInterface  $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $equipmemtsQuery = $em->getRepository(PortableEqipment::class)->findAllQuery();

        $equipmemts = $paginator->paginate(
            $equipmemtsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 15)
        );

        $code = Response::HTTP_OK;
        $message = Codes::$statusTexts[$code];
        $view = $this->view( [ 'message' => $message, 'data' => $equipmemts], 200);
        $view->getContext()->setGroups(['api_response', 'equipment_list']);
        $view->getContext()->setSerializeNull(true);

        return $this->handleView($view);
    }
}
