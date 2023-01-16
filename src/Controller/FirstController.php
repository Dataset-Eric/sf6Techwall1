<?php
namespace App\Controller ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/order/{maVar}', name:'test.order.route')]
    public function testOrderRoute($maVar){
        return new Response("<html><body>$maVar</body></html>");
    }

    #[Route('/first', name:'first')]
    public function index():Response{
/*        return new Response(
            "<head><title>Ma première page</title>
            <body>
                <h1>Hello techwall symphony 6</h1>
            </body>
            </head>"
        );
*/
        return $this->render('first/index.html.twig',['firstname'=>'Eric','lastname'=>'Wauthion']);
    }

    #[Route('/hello/{name}', name:'say.hello')]
    public function sayHello(Request $request, $name):Response{
        //die and dump : afficher et tue le process
        //dd($request);
        return $this->render('first/hello.html.twig',['nom'=>$name]);
    }

    #[Route(
        '/multi/{entier1}/{entier2}',
        name:'multiplication',
        requirements:['entier1'=>'\d+','entier2'=>'\d+']
    )]
    public function multiplication(int $entier1, int $entier2){
        $resultat = $entier1 * $entier2 ;
        return new Response ("<h1>$resultat</h1>");
    }

    /**
     * les <> derière les paramètres de la route sont des requirements
     * @param int $entier1
     * @param int $entier2
     * @return Response
     */
    #[Route(
        '/multi/{entier1<\d+>}/{entier2<\d+>}',
        name:'multiplication2',
    )]
    public function multiplication2(int $entier1, int $entier2){
        $resultat = $entier1 * $entier2 ;
        return new Response ("<h1>$resultat</h1>");
    }
}
