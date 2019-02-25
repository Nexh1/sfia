<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\EntreprisesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function adminHome(ArticleRepository $articleRepo, EntreprisesRepository $entreRepo) {
        $articles = $articleRepo->findLast5();
        $articlesCount = count($articleRepo->findAll());
        $entres = $entreRepo->findLast5();
        $entresCount = count($entreRepo->findAll());
        
        return $this->render('panelAdmin/dashboard.html.twig', [
            'articles' => $articles,
            'articlesCount' => $articlesCount,
            'entres' => $entres,
            'entresCount' => $entresCount
        ]);
    }
}
