<?php

namespace App\Form;

use App\Entity\Entreprises;
use App\Entity\SavoirFaire;
use App\Form\SavoirCreateType;
use App\Entity\SecteurActivite;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Repository\SavoirFaireRepository;
use Symfony\Component\Form\FormInterface;
use App\Repository\SecteurActiviteRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class EntreprisesCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('raisonSociale')
            ->add('adresse')
            ->add('codePostal', TextType::class)
            ->add('ville')
            ->add('telephone')
            ->add('fax')
            ->add('siteWeb')
            ->add('email', EmailType::class)
            ->add('formeJuridique')
            ->add('effectif')
            ->add('surfaceCouverte')
            ->add('chiffreAffaire')
            ->add('export')
            ->add('exportTotal')
            ->add('codeNaf')
            ->add('capital')
            ->add('nomDirigeant')
            ->add('emailDirigeant', EmailType::class)
            ->add('nomResCom')
            ->add('emailResCom', EmailType::class)
            ->add('nomResAchat')
            ->add('emailResAchat', EmailType::class)
            ->add('equipements', TextareaType::class)
            ->add('qualiteAgrement')
            ->add('qualite', TextareaType::class)
            ->add('manutention', TextType::class, [
                'empty_data' => '',
            ])
            ->add('referencesClients', TextareaType::class, [
                'empty_data' => '',
            ])
            ->add('pointFort', TextareaType::class, [
                'empty_data' => '',
            ])
            ->add('siret')
            // ->add('updatedAt')
            ->add('icpe')                               
            ->add('savoirFaire', TextareaType::class)                               
            ->add('environnement', TextType::class)                               
            ->add('savoirFaireSearch', TextareaType::class)                               
            ->add('secteursActivite', TextareaType::class)                               
        ;
    }

        // // simple entitytype with query
        // $builder->add('savoirFaire', EntityType::class, [
        //     'class' => SavoirFaire::class,
        //     'required' => false,
        //     'query_builder' => function(SavoirFaireRepository $er) {
        //         return $er->createQueryBuilder('a')
        //                   ->orderBy('a.nomFr', 'ASC');
        //     },  
        // ]);


        

        // $builder->add('secteurActivite', EntityType::class, [
        //     'class' => SecteurActivite::class,
        //     'query_builder' => function(SecteurActiviteRepository $er) {
        //         return $er->createQueryBuilder('a')
        //                   ->orderBy('a.nom', 'ASC');
        //     },  
        // ]);    


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprises::class,
        ]);
    }
}
