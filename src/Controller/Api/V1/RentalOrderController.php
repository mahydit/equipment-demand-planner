<?php

namespace App\Controller\Api\V1;

use App\Entity\RentalOrder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as Codes;



class RentalOrderController extends AbstractFOSRestController
{
    /**
     * list all orders
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Codes
     */
    public function index(Request $request, PaginatorInterface  $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $ordersQuery = $em->getRepository(RentalOrder::class)->findAllQuery();

        $orders = $paginator->paginate(
            $ordersQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 15)
        );

        $code = Response::HTTP_OK;
        $message = Codes::$statusTexts[$code];
        $view = $this->view( [ 'message' => $message, 'data' => $orders], 200);
        $view->getContext()->setGroups(['api_response', 'order_list']);
        $view->getContext()->setSerializeNull(true);

        return $this->handleView($view);
    }


}
