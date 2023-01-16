<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session',name:'session')]
    public function index(Request $request):Response{
        //équivalent à session_start()
        //va récupérer la session de l'utilisateur
        $session = $request->getSession();
        //si l'utilisateur est déjà venu sur le site on incrémente le compteur sinon on l'initialise à 1
        if ($session->has('nbVisite')){
            $nbrVisites = $session->get('nbVisite') + 1 ;
        }else{
            $nbrVisites = 1;
        }
        //On sauve le nombre de visite dans la session
        $session->set('nbVisite',$nbrVisites);

        return $this->render(
            'session/index.html.twig',
            ['nbVisite'=>$nbrVisites]);
    }
}
