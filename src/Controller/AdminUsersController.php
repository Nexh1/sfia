<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UsersCreateType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUsersController extends AbstractController
{
    /**
     * @Route("/admin/liste_utilisateurs", name="admin_show_users")
     */
    public function listUsers(UserRepository $user) {
        
        $allUsers = $user->findAll();
        $simpleUsers = $user->findByRole("ROLE_USER");

        return $this->render('panelAdmin/admin_users/show.html.twig', [
            'users' => $allUsers,
            'simpleUsers' => $simpleUsers
        ]);
    }

    public function generatePassword($length = 8, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $PasswordLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $PasswordLength - 1)];
        }
        return $randomPassword;
    }

    /**
     *@Route("/admin/ajouter_utilisateur", name="admin_create_user")
     */
    public function createUsers(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer) {
        // make new user
        $user = new User();
        // get the role
        $user_roles = $this->getUser()->getRoles();
        // create form and pass the role 
        $form = $this->createForm(UsersCreateType::class, $user, array('role' => $user_roles));    
        // add to db
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime());
            $user->setPassword($this->generatePassword());

            // send email with password before encode
            $mail = $user->getEmail();
            $password =  $user->getPassword();
            $user->setFirstLogin(true);
            $message = (new \Swift_Message('Votre Mot de passe'))
            ->setFrom('contactsfia@kevinponsart.com')
            ->setTo($mail)
            ->setBody(
                $this->renderView(
                    'security/emails/email.html.twig',
                    array('password' => $password)
                ),
                'text/html'
            );
            $mailer->send($message);
            //  encode password
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            // add role user to new user if redacteur create the user
            if(in_array('ROLE_REDACTEUR',$user_roles) || $user_roles = ['']) {
                $user->setRoles(['ROLE_USER']);
            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'utilisateur a bien été ajouté !"
            );
        }

        return $this->render('panelAdmin/admin_users/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer_utilisateur/{id}", name="admin_delete_user")
     */
    public function deleteUser($id, UserRepository $repoUser, ObjectManager $manager) {
        $currentUser = $repoUser->find($id);

        if($currentUser) {
            $manager->remove($currentUser);
            $manager->flush($currentUser);

            $this->addFlash(
                'danger',
                "L'utilisateur a été supprimé avec succès !"
            );
        }
        return $this->redirectToRoute('admin_show_users');
    }

    /**
     * @Route("/admin/pass_utilisateur/{id}", name="admin_password_user")
     */
    public function PasswordUser($id, UserRepository $repoUser, ObjectManager $manager,\Swift_Mailer $mailer,UserPasswordEncoderInterface $encoder) {
        $user = $repoUser->find($id);

        if($user) {
            $user->setPassword($this->generatePassword());
            // send email with password before encode
            $mail = $user->getEmail();
            $password =  $user->getPassword();
            $user->setFirstLogin(true);
            $message = (new \Swift_Message('Votre Mot de passe'))
            ->setFrom('contactsfia@kevinponsart.com')
            ->setTo($mail)
            ->setBody(
                $this->renderView(
                    'security/emails/resetPassword.html.twig',
                    array('password' => $password)
                ),
                'text/html'
            );
            $mailer->send($message);
            //  encode password
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();            

            $this->addFlash(
                'warning',
                "Un email vient d'être envoyé à l'utilisateur lui permettant de réinitialiser son mot de passe !"
            );
        }

        return $this->redirectToRoute('admin_show_users');
    }

}
