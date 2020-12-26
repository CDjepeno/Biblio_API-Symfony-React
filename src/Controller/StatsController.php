<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatsController extends AbstractController
{
    /**
     * Renvoi le nombre de prêt par membre
     * @Route(
     *      path="apiPlatform/member/nbRentsPerMember",
     *      name="member_nbRent",
     *      methods={"GET"}
     * )
     */
    public function numberRentsPerMember(MemberRepository $data)
    {
        $nbRentPerMember = $data->getNbRentPerMember();
        
        return $this->json($nbRentPerMember);
    }

    /**
     * @Route(
     *      path="apiPlatform/bestbook",
     *      name="best_book",
     *      methods={"GET"}
     * )
     */
    public function bestBook(BookRepository $data)
    {
        $bestBook = $data->getBest5Book();
        
        return $this->json($bestBook);
    }
}
