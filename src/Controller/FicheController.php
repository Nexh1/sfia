<?php

namespace App\Controller;

use App\Entity\Entreprises;
use App\Service\PaginationSearch;
use App\Repository\EntreprisesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FicheController extends AbstractController
{
    /**
     * @Route("/fiche/{id}", name="fiche")
     */
    public function fiche($id, Request $request, EntreprisesRepository $repoEntre)
    {    
        
        $entre = $repoEntre->find($id); 
        
        return $this->render('fiche/fiche.html.twig', [
            'entre' => $entre
        ]);
    }

    /**
     * @Route("/fiche_entreprise/", name="fiche_entreprise")
     */
    public function ficheEntreprise(Request $request, EntreprisesRepository $repoEntre)
    {    
        $id = $request->get('entres');
        
        $entre = $repoEntre->find($id); 
        
        return $this->render('fiche/fiche.html.twig', [
            'entre' => $entre
        ]);
    }

    /**
     * @Route("/resultats", name="results")
     */
    public function results(Request $request, EntreprisesRepository $repoEntre) {
        
        $savoirsReq = $request->get('savoirs');
        $secteursReq = $request->get('secteurs');
        //  handle savoir form
        if(isset($savoirsReq) && !empty($savoirsReq)) {
            $savoirs = $repoEntre->findBySavoir($savoirsReq);  
            
            return $this->render('fiche/results.html.twig', [
                'savoirs' => $savoirs
            ]);
        }      
        // handle secteur form      
        if(isset($secteursReq) && !empty($secteursReq)) {     

            $secteurs = $repoEntre->findBySecteur($secteursReq);  
            
            return $this->render('fiche/results.html.twig', [
                'secteurs' => $secteurs
            ]);
        }
    }

    /**
     * @Route("/recherche{page<\d+>?1}{search = null}", name="search_results")
     */
    public function searchResults($search = null, $page, PaginationSearch $pagination, Request $request, EntreprisesRepository $repoEntre) {     
        // get search input 
        $searchReq = $request->get('search');
        // get checkbox  
        $exportReq = $request->get('export');
        $qualiteReq = $request->get('qualite');
        $icpeReq = $request->get('icpe');
        // get results and make the pagination
        $pagination->setRepo($repoEntre)
                   ->setSearch($searchReq)
                   ->setExport($exportReq)
                   ->setQualite($qualiteReq)
                   ->setPage($page);

        // if no results are found
        $emptySearch = false;
        if(empty($pagination->getData())) {
            $emptySearch = true;
        } 
        
        return $this->render('fiche/results.html.twig', [
            'emptySearch' => $emptySearch,
            'pagination' => $pagination
        ]);
    }
}
