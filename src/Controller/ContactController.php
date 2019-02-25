<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $subject = $form->get('subject')->getData();
            $mail = $form->get('email')->getData();
            $name = $form->get('name')->getData();
            $message = $form->get('message')->getData();

            if(empty($request->get('g-recaptcha-response'))) {
                $this->addFlash(
                    'danger',
                    "Veuillez remplir le captcha"
                );
                return $this->redirectToRoute('contact');
            }

            $message = (new \Swift_Message($subject))
            ->setFrom($mail)
            ->setTo('contactsfia@kevinponsart.com')
            ->setBody(
                $this->renderView(
                    'security/emails/contact.html.twig',
                    array(
                        'message' => $message,
                        'name' => $name
                    )
                ),
                'text/html'
            );

            $mailer->send($message);
            
            $this->addFlash(
                'success',
                "Votre message a bien été envoyé"
            );


            return $this->redirectToRoute('home');
        }

        return $this->render('contact/contact.html.twig', [
               'form' => $form->createView()
        ]);
    }
}
