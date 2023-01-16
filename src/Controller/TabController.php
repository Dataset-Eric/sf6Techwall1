<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    /**
     * nb : Longueur du tableau avec 5 éléments par défaut
     * @return Response
     */
    #[Route('/tab/{nb?5<\d+>}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes=[];
        for($i=1 ; $i<=$nb ; $i++){
            $notes[] = rand(0,20);
        }

        return $this->render('tab/index.html.twig', [
            'notes' => $notes
        ]);
    }
}
