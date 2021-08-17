<?php

namespace App\Controller\Admin;

use App\Repository\PortableEqipmentTypeRepository;
use App\Repository\RentalOrderRepository;
use App\Repository\StationRepository;
use App\Utils\RentalOrderHelper;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @var RentalOrderRepository
     */
    public $orderRepository;

    /**
     * @var StationRepository
     */
    public $stationRepository;

    /**
     * @var PortableEqipmentTypeRepository
     */
    public $portableEqipmentTypeRepository;

    public function __construct(
        RentalOrderRepository $orderRepository,
        StationRepository $stationRepository,
        PortableEqipmentTypeRepository $portableEqipmentTypeRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->stationRepository = $stationRepository;
        $this->portableEqipmentTypeRepository = $portableEqipmentTypeRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard/dashboard.html.twig');
    }

    /**
     * @Route("/admin/rent-details/{date}", options={"expose"=true}, name="admin_rent_details_ajax", methods={"GET"})
     */
    public function getRentDetails($date)
    {
        $orderEquipmentsDetails = $this->orderRepository->findOrderEquipmentsByDate($date);

        $availableEquipmentsPerStation = $this->stationRepository->findAvailableEquipments();
        $equipmentsLeftStation =$this->orderRepository->findEquipmentsOutOfStationsByDate($date);
        $equipmentsReturnedToStation = $this->orderRepository->findEquipmentsReturnedToStationsByDate($date);
        $rentalHelpers = new RentalOrderHelper($this->stationRepository, $this->portableEqipmentTypeRepository);
        $availableEquipmentsPerStationByDate = $rentalHelpers->calculateAvailableEquipments(
            $availableEquipmentsPerStation,
            $equipmentsLeftStation,
            $equipmentsReturnedToStation
        );

        return new JsonResponse([
            'equipments_ details' => RentalOrderHelper::mapEquipmentsCountByStation($orderEquipmentsDetails),
            'equipments_available' => $availableEquipmentsPerStationByDate,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Equipment Demand Planner');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
    }
}
