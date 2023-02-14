<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// use mailer
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/register', name: 'register', methods: ['GET', 'POST'])]
    public function create(Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(\App\Form\UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setActivationToken(md5(uniqid()));
            $user->setActivationTokenExpiration(new \DateTime('+1 day'));
            // check if user mail already exist
            $mailExist = $userRepository->findOneBy(['email' => $user->getEmail()]);
            $usernameExist = $userRepository->findOneBy(['username' => $user->getUsername()]);
            if ($mailExist) {
                $this->addFlash('danger', 'Cette adresse email est déjà utilisée.');
            }  
            if ($usernameExist) {
                $this->addFlash('danger', 'Ce nom d\'utilisateur est déjà utilisé.');
            } 
            if(!$mailExist && !$usernameExist) {
              $userRepository->save($user, true);
              $email = (new Email())
                  ->from('support@'.$_ENV['DOMAIN_NAME'])
                  ->to($user->getEmail())
                  ->subject('Activation de votre compte')
                  ->html($this->renderView('Front/email/activation.html.twig', [
                      'activation_token' => $user->getActivationToken()
                  ]));
              $mailer->send($email);
              $this->addFlash('success', 'Your account has been created. Please check your email to activate it.');
              return $this->redirectToRoute('front_default_index');
            }
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/profile', name: 'profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(\App\Form\UserType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('front_default_index');
        }

        return $this->render('security/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/activation/{token}', name: 'activate_account')]
    public function activation(string $token, UserRepository $userRepository): Response
    {

        $hasError = false;
        $user = $userRepository->findOneBy(['activation_token' => $token]);
        if (!$user) {
           $message = 'Ce token est invalide';
           $hasError = true;
        }else{

            if ($user->getActivationTokenExpiration() < new \DateTime()) {
                $message = 'Ce token a expiré';
                $hasError = true;
            }
    
            if($user->isActive() === true) {
                $message = 'Ce compte est déjà activé';
                $hasError = true;
            }
    
            if($hasError === false){
                $message = 'Votre compte a bien été activé';
                $user->setActive(true);
                $userRepository->save($user, true);
            }

        }

        return $this->render('security/activate.html.twig', [
            'message' => $message
        ]);
    
    }

}