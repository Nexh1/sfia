<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/account/login.html.twig', [
            'last_username' => $lastUsername, 'error' => $error
        ]);
    }


    /**
     * @Route("/firstLogin", name="security_first_login")
     */
    public function firstLogin() {
        $userNew = $this->getUser()->getFirstLogin();
        
        if($userNew == 1) {
            $this->addFlash(
                'warning',
                "Veuillez réinitialiser votre mot de passe"
            );
            return $this->redirectToRoute('reset_password');
        } else {
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/nouveau_mot_de_passe" , name="reset_password")
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager) {
        $user = $this->getUser();  
        if($user == null || $user->getFirstlogin() == 0) {
            return $this->redirectToRoute('home');
        } else {
            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {  

                $pass = $form->get('password')->getData();
                $user->setPassword($pass);
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setFirstLogin(false);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été réinitialisé."
                );

                return $this->redirectToRoute('security_logout');
            } else {
                return $this->render('security/account/resetPassword.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }   
        
    }

    /**
     * @ROute("/deconnexion", name="security_logout")
     */
    public function logout(Request $request) {

        return $this->redirectToRoute('security_login');
    }

}
