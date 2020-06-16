<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {
        $contact = new Contact(); 

        $url = $this->generateUrl('home', [
            '_fragment' => 'formulaire'
        ]);

       //$form = $this->createForm(ContactType::class, $contact, ['action' => $url]);

       $form = $this->createForm(ContactType::class, $contact);
       
       $form->handleRequest($request);
       if($form->isSubmitted() && !$form->isValid())
       {
           
           //dd('coco');
           
           if($request->isXmlHttpRequest())
           {
               
                
                //$form->handleRequest($request);

                // foreach($form->getErrors(true) as $errors)
                // {
                //     dump($errors->getOrigin()->getName());
                //     dump($errors->getMessage());
                // }
        
                $error = [];
                $champ = [];
                $test = "";
        
                foreach($form->getErrors(true) as $errors)
                {
                    if($test)
                    {
                        if( $test == $errors->getOrigin()->getName() )
                        {
                            $champ[] = $errors->getMessage();
                            dump("champ",$champ);
                        }
                        else
                        {
                            //dump($champ);
                            dump("error",$error[] = $champ);
                            $champ = [];
                            $test = $errors->getOrigin()->getName();
                            dump($champ[] = $errors->getOrigin()->getName());
                            dump($champ[] = $errors->getMessageTemplate());
                        }
                    }
                    else
                    {
                        $test = $errors->getOrigin()->getName();
                        dump($champ[] = $errors->getOrigin()->getName());
                        dump($champ[] = $errors->getMessage());
                    }
                    
                    
                }
        
                if($champ)
                {
                    $error[] = $champ;
                }
        
            // dump("errors",$error);
        
                // if($form->sSubmitted())
                // {
                        //  on envoie un mail ..
                // }
                //$form = $this->createForm(ContactType::class, $contact, ['action' => $url]);

            
                return $this->json('choucou');
                return $this->json($error);
        
            }
       }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView()
        ]);
    }


    




    /**
     * @Route("/register", name="user_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {

            $plainPassword = $user->getPassword();
            $hash = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("security_login");
        }

        return $this->render('home/user_create.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView()
        ]);
    }



    // private function donneesFormulaire()
    // {
    //     $test = $errors->getOrigin()->getName();
    //     dump($champ[] = $errors->getOrigin()->getName());
    //     dump($champ[] = $errors->getMessage());
    // }


}
