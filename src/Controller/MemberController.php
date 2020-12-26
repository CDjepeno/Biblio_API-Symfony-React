<?php

namespace App\Controller;

use App\Entity\Member;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemberController extends AbstractController
{
    /**
     * Renvoie le nombre de prets pour un membre
     * @Route(
     *      path="apiPlatform/member/{id}/rent/count", 
     *      name="member_rent_count",
     *      methods={"GET"},
     *      defaults={
     *          "_controller"="\app\controller\MemberController::numberRents",
     *          "_api_ressource_class"="App\Entity\Member",
     *          "_api_item_operation_name"="getNbRents"
     *      }
     * )
     */
    public function numberRents(Member $data)
    {
        $count = $data->getBookRents()->count();
        return $this->json([
            "id" => $data->getId(),
            "number_rent" => $count
        ]);
    }
}
