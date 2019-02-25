<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Entreprises;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('entreprise', EntityType::class, [
                'class' => Entreprises::class,
                'choice_label' => 'raisonSociale',
                'required' => false
            ])
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
        ;
        // if user is admin
        if (in_array('ROLE_ADMIN', $options['role'])) {
            $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Redacteur' => 'ROLE_REDACTEUR',
                    'Utilisateur' => 'ROLE_USER'
                ],
                'multiple' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'role' => ['ROLE_REDACTEUR']
        ]);
    }
}
