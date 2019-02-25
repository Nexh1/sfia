<?php

namespace App\Controller;

use App\Entity\SavoirFaire;
use App\Entity\SecteurActivite;
use App\Form\EntreprisesCreateType;
use App\Repository\SavoirFaireRepository;
use App\Repository\SecteurActiviteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserSpaceController extends AbstractController
{
    /**
     * @Route("/espace_entreprises" , name="espace_entreprises")
     */
    public function espaceEntreprise() {
        $user = $this->getUser();
        
        if($user && $user->getEntreprise() !== null) {
            $entre = $user->getEntreprise();
            return $this->render('fiche/user_fiche.html.twig', [
                'entre' => $entre,
                'user' => $user
            ]);
        } 
        
        else {
            return $this->render('fiche/user_fiche.html.twig', [
                'user' => $user
            ]);
        }
    }

     /**
     * @Route("/espace_entreprises/modifier" , name="espace_entreprises_edit")
     */
    public function espaceEntrepriseCreate(Request $request, SavoirFaireRepository $repoSavoir, SecteurActiviteRepository $repoSecteur, ObjectManager $manager) {
        $user = $this->getUser();
        $entre = $user->getEntreprise();

        $form = $this->createForm(EntreprisesCreateType::class, $entre);

       
        $savoirs = $repoSavoir->findByAlphabet();
        $secteurs = $repoSecteur->findByAlphabet();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {           

            $reqSavoirs = $form['savoirFaire']->getData();
            $reqSavoirsArray = explode(',', $reqSavoirs);
            $reqSecteurs = $form['secteursActivite']->getData();      
            
            // add savoir & secteur to entreprise
            if(!empty($reqSavoirs) && isset($reqSavoirs)) { 
                $savoirCon = '';          
                foreach($reqSavoirs as $a) {               
                    $check = $repoSavoir->findBy(['nomFr' => $a]);
                    
                    if(!$check) {      
                        $savoirCon .= $a.', ';
                        $savoir = new SavoirFaire();
                        $savoir->setNomFr($a);                    
                        $manager->merge($savoir);
                        $manager->flush();   
                    } else {
                        $savoirCon .= $a.', ';                           
                    }     
                }
            } 

            if(!empty($reqSecteurs) && isset($reqSecteurs)) {
                $secteurCon = '';
                foreach($reqSecteurs as $a) {
                    $check = $repoSecteur->findBy(['nom' => $a]);
                    
                    if(!$check) {
                        $secteurCon .= $a.', ';
                        $secteur = new SecteurActivite();
                        $secteur->setNom($a);
                        $manager->merge($secteur);
                        $manager->flush();   
                    } else {
                        $secteurCon .= $a.', ';
                    }                             
                }
            }          

            $entre->setUpdatedAt(new \DateTime());
            $manager->merge($entre);
            $manager->flush();

            $this->addFlash(
                'success',
                "Fiche entreprise modifiée avec succès !"
            );

        }
    
        return $this->render('fiche/editEntreprise.html.twig', [
            'entre' => $entre,
            'form' => $form->createView(),
            'savoirsSearch' => $savoirs,
            'secteurs' => $secteurs
        ]);
    }
}
