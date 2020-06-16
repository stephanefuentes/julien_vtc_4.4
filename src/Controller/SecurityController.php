<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login") 
     */
    public function login(AuthenticationUtils $util)
    {

    $error = $util->getLastAuthenticationError();
    $last_user_name = $util->getLastUsername();
        dump($error);
        // dd($error->getToken()->getUser());

        // if($error)
        // {
        //     throw new BadCredentialsException('Erreur blaireau');
        // }

         
            
// last username entered by the user
//         $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            'error' => $error,
            'last_user_name' => $last_user_name
        ]);
    }


    /** 
     *@Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}
