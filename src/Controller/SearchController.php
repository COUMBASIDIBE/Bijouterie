<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{


    /**
     * @Route("/searchrender", name="searchrender")
     */
    public function search(ArticleRepository $repository, Request $request, PaginatorInterface $paginator)
    {

        $article = $repository->search($request->query->get('search'));

        // si la requête retourne un article, l'article est renvoyé vers la page detail
        if (count($article) === 1){

            $articles = $paginator->paginate(
                $article, // on passe les données
                $request->query->getInt('page', 1),3 //numero 1 page par defaut

            );

            return $this->render('find.html.twig',
                [
                    'articles' => $articles
                ]
            );
        }
        // si la requête ne retourne pas de article, l'article est renvoyé vers une page
        // lui indiquant que sa requête n'a pas retourné de résultats
//        elseif (count($article) === 0){
//            return $this->render('message.html.twig',
//                [
//
//                    'article' => $article,
//
//                ]
//            );
//        }
        // si plusieurs article correspondent à la requête, l'article est renvoyé vers le tableau
        // présentant ceux-ci
        else {

            $articles = $paginator->paginate(
                $article, // on passe les données
                $request->query->getInt('page', 1),3 //numero 1 page par defaut

            );

            return $this->render('find.html.twig',
                [
                    'articles' => $articles

                ]
            );

        }

    }

    /**
     * @Route("/handle_search")
     * @return JsonResponse
     */
    public function autocomplete(Request $request)
    {

        $term = $request->query->get('query');

        $array = $this->getDoctrine()
            ->getManager()
            ->getRepository(Article::class)
            // la méthode présente dans le repository article est utilisée ici en paramètre
            ->autocomplete($term);

        // le résultat est ensuite encodé au format json pour l'appel en ajax
        return new JsonResponse($array);
    }






}


