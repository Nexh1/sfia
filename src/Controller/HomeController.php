<?php

namespace App\Controller;

use App\Entity\Entreprises;
use App\Form\HomeSearchType;
use App\Form\EntreprisesCreateType;
use App\Repository\EntreprisesRepository;
use App\Repository\SavoirFaireRepository;
use App\Repository\SecteurActiviteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function forms(Request $request, EntreprisesRepository $repoEntre, SavoirFaireRepository $repoSavoir, SecteurActiviteRepository $repoSecteur) {
        $formLibre = $this->createForm(HomeSearchType::class);

        $entres = $repoEntre->findByAlphabet();
        $savoirs = $repoSavoir->findByAlphabet();
        $secteurs = $repoSecteur->findByAlphabet();

        return $this->render('home/home.html.twig', [ 
            'formLibre' => $formLibre->createView(),
            'entres' => $entres,       
            'savoirs' => $savoirs,       
            'secteurs' => $secteurs       
        ]);
    }

    /**
     * @Route("/bloc_note", name="bloc_note")
     */
    public function blocNote() {
        return $this->render('home/bloc_note.html.twig');
    }

    /**
     * @Route("/edito", name="edito")
     */
    public function edito() {
        return $this->render('home/edito.html.twig');
    }

    /**
     * @Route("/les_ardennes", name="les_ardennes")
     */
    public function ardennes() {
        return $this->render('home/ardennes.html.twig');
    }

}
