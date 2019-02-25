<?php

namespace App\Controller;

use App\Entity\Entreprises;
use App\Entity\SavoirFaire;
use App\Entity\SecteurActivite;
use App\Form\EntreprisesCreateType;
use App\Repository\EntreprisesRepository;
use App\Repository\SavoirFaireRepository;
use App\Repository\SecteurActiviteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEntreprisesController extends AbstractController
{
    /**
     * @Route("/admin/liste_entreprises", name="admin_show_entreprises")
     */
    public function showEntreprise(EntreprisesRepository $entre) {
        $entres = $entre->findAll();
        
        return $this->render('panelAdmin/Admin_Entreprises/show.html.twig', [
            'entres' => $entres
        ]);
    }

    /**
     * @Route("/admin/ajouter_entreprise", name="admin_create_entreprise")
     * @Route("/admin/modifier/{id}", name="admin_edit_entreprise")
     */
    public function createEntreprise(Entreprises $entre = null, Request $request, ObjectManager $manager, SavoirFaireRepository $repoSavoir, SecteurActiviteRepository $repoSecteur, SessionInterface $session, EntreprisesRepository $repoEntre) {
        if(!$entre) {
            $entre = new Entreprises();
        }

        // trick to redirect and flash message
        if($entre->getId() !== null) {
            $edit = 1;
        }
        
        // get savoirs / secteurs
        $savoirs = $repoSavoir->findByAlphabet();
        $secteurs = $repoSecteur->findByAlphabet();

        // generate form
        $form = $this->createForm(EntreprisesCreateType::class, $entre);
        
        // handle form
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {           
            
            $reqSavoirs = $request->get('savoirs', []);
            $reqSecteurs = $request->get('secteurs', []);      

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

            if(isset($edit) && $edit == 1) {
                $this->addFlash(
                    'success',
                    "Entreprise modifiée avec succès !"
                );
                return $this->redirectToRoute('admin_show_entreprises');
            } else {
                $this->addFlash(
                    'success',
                    "Entreprise ajoutée avec succès !"
                );
                return $this->redirectToRoute('admin_create_entreprise');
            }
        }

        return $this->render('panelAdmin/Admin_Entreprises/create.html.twig', [
            'form' => $form->createView(),
            'savoirsSearch' => $savoirs,
            'secteurs' => $secteurs,
            'editMode' => $entre->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/supprimer_entreprise/{id}", name="admin_delete_entreprise")
     */
    public function deleteEntreprise($id, EntreprisesRepository $repoEntre, ObjectManager $manager) {
        $currentEntre = $repoEntre->find($id);

        if($currentEntre) {
            $manager->remove($currentEntre);
            $manager->flush($currentEntre);

            $this->addFlash(
                'danger',
                "Entreprise supprimée avec succès !"
            );
        }
        
        return $this->redirectToRoute('admin_show_entreprises');
    }
}
