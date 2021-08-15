<?php

namespace App\Controller\Api\V1;

use App\Entity\Campervan;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as Codes;



class CampervanController extends AbstractFOSRestController
{
    /**
     * list all campervans
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Codes
     */
    public function index(Request $request, PaginatorInterface  $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $campervansQuery = $em->getRepository(Campervan::class)->findAllQuery();

        $campervans = $paginator->paginate(
            $campervansQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 15)
        );

        $code = Response::HTTP_OK;
        $message = Codes::$statusTexts[$code];
        $view = $this->view( [ 'message' => $message, 'data' => $campervans], 200);
        $view->getContext()->setGroups(['api_response', 'campervan_list']);
        $view->getContext()->setSerializeNull(true);

        return $this->handleView($view);
    }


}
