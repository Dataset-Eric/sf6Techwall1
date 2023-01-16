<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/todo")]
class TodoController extends AbstractController
{
    /**
     * Affiche la liste des todos
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        //si je n'ai pas ma session je l'initialise puis j'affiche
        //sinon j'ai mon tableau de todos dans la session je ne fais que l'afficher
        $session = $request->getSession();

        if(!$session->has('todos')){
            $toDo = [
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'Corriger mes examens'];
            $session->set('todos',$toDo);
            $this->addFlash('info',"La liste des todos vient d'être initialisée");
        }
        return $this->render('todo/index.html.twig');
    }

    /**
     * Ajoute une élément dans la liste et affiche la liste
     * @param Request $request
     * @param $name
     * @param $content
     * @return RedirectResponse
     */
    #[Route('/add/{name}/{content}', name:'todo.add', defaults: ['content'=>'Tache a faire', 'name'=>'Dimanche'])]
    public function addToDo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();

        //Vérifier que la liste est initialisée
        if ($session->has('todos')){
            //récupérer la liste dans un tableau
            $toDo = $session->get('todos');

            //Vérifier que l'élément n'existe pas déjà dans la liste
            if (!isset($toDo[$name])){
                //Ajouter l'élément dans la liste
                $toDo[$name] = $content;
                //Ajouter un msg ajouté
                $this->addFlash('success', "le toto d'id $name a été ajouté avec succès");
                //Sauver l'élément en session
                $session->set('todos',$toDo);
            }else{
                $this->addFlash('error', "L'élément $name existe déjà dans la liste");
            }
        }else{
            //La liste n'est pas initialisée on ajoute un message d'erreur
            $this->addFlash('error', "la liste des todos n'est pas initialisée");
        }

        //Afficher la liste
        return $this->redirectToRoute('app_todo');
    }

    /**
     * Modifier un élément de la liste des todos en session
     * @param Request $request
     * @param $name
     * @param $content
     * @return RedirectResponse
     */
    #[Route('/update/{name?lundi}/{content}', name:'todo.update')]
    public function update(Request $request, $name, $content):RedirectResponse
    {
        //charger la session en variable
        $session=$request->getSession();

        //si la liste existe bien dans la session
        if($session->has('todos')){
            //charger la liste en variable
            $toDo = $session->get('todos');

            //si l'élément à modifier existe bien
            if (isset($toDo[$name])){
                //Modifier l'élément
                $toDo[$name] = $content;
                //sauver l'élément
                $session->set('todos',$toDo);
                //message ok
                $this->addFlash("success","La tâche $name a été modifiée");
            }else{
                // afficher un message d'erreur
                $this->addFlash("error","La tâche $name n'existe pas");
            }
        }else{
            //  Afficher un message d'erreur si pas de liste
            $this->addFlash("error", "La liste des tâches n'existe pas");
        }
        //Rediriger vers l'affichage de la liste
        return $this->redirectToRoute("app_todo");
    }

    /**
     * Suppression d'un élément de la liste
     * @param Request $request
     * @param $name
     * @return RedirectResponse
     */
    #[Route('/delete/{name}',name:'todo.delete')]
    public function delete(Request $request, $name):RedirectResponse{
        $session = $request->getSession();

        if ($session->has('todos')){
            $toDo = $session->get('todos');

            if (isset($toDo[$name])){
                //$toDo[$name]="";
                unset($toDo[$name]);
                $session->set('todos',$toDo);
                $this->addFlash('success', "La tache $name a été supprimée");
            }else{
                $this->addFlash('error',"La tache $name n'existe pas");
            }
        }else{
            $this->addFlash('error',"La liste des tâches n'existe pas");
        }
        return $this->redirectToRoute("app_todo");
    }
}
