<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;



class HomeController extends AbstractController
{



 





    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $manager, ValidatorInterface $validator)
    {
        $contact = new Contact(); 

        $url = $this->generateUrl('home', [
            '_fragment' => 'formulaire'
        ]);

        // $url = $this->generateUrl('formulaire_contact_ajax', [
        //     '_fragment' => 'formulaire'
        // ]);

       $form = $this->createForm(ContactType::class, $contact, ['action' => $url]);
       
       //$form = $this->createForm(ContactType::class, $contact);

        dump(json_decode('{"contact[firstName]":"sdfsdfsd","contact[lastName]":"egergreg kjj","contact[email]":"sdpoppf@yahoo.fr","contact[commentaire]":"llk lklk ","contact[_token]":"wENKvFj0ThJQL9MMIEoWHh_v5SeV7exPqO3DWprXDV4"}',true));
  

        if( $request->isXmlHttpRequest())
        {
            // le 2eme parametre à true permet de formater le retour en tableau assiossatif, et non sous forme d'objet
            $data = json_decode($request->getContent(), true);
            //unset($data["contact[_token]"]);
            dump('je passe dans a prtie Ajax');
            //$data = json_decode('{"contact[firstName]":"sdfsdfsd","contact[lastName]":"egergreg kjj","contact[email]":"sdpoppf@yahoo.fr","contact[commentaire]":"llk lklk ","contact[_token]":"wENKvFj0ThJQL9MMIEoWHh_v5SeV7exPqO3DWprXDV4"}',true);

           //$data = json_decode($request->getContent());
            //$data = $request->getContent();
            dump($data);

            $form->submit($data);
            // dump($form->isSubmitted());
            // dump($form->isValid());
            //dump($form->isValid());

            //return $this->json(count($form->getErrors(true)));


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
                $dataTest = json_encode($error);




            if($form->isValid())
            {
                return $this->json($error);
                return $this->json('le formulaire est valide , enregistre fissa');
            }
            else{
                //return $this->json('le formulaire n est pas valide , blaireau');
                return $this->json($error);
                
            }

            return $this->json('je passe dans isXmlHttpRequest() ');

        }// fin requette Ajax

       // dump($form->isSubmitted());

        if( $form->isSubmitted())
        {
            dd('ok cool');
            dump($form->isSubmitted());
            $contact->setFirstName($request->request->get(["contact[firstName]"]))
                ->setLastName($request->request->get(["contact[lastName]"]))
                ->setEmail($request->request->get(["contact[email]"]))
                ->setCommentaire($request->request->get(["contact[commentaire]"]));

                $liste_erreurs = $validator->validate($contact);
                dump(count($liste_erreurs));
        }



       $form->handleRequest($request);
    //    if($form->isSubmitted() && !$form->isValid())
    //    {
           
    //        //dd('coco');
           
    //        if($request->isXmlHttpRequest())
    //        {
               
                
    //             //$form->handleRequest($request);

    //             // foreach($form->getErrors(true) as $errors)
    //             // {
    //             //     dump($errors->getOrigin()->getName());
    //             //     dump($errors->getMessage());
    //             // }
        
    //             $error = [];
    //             $champ = [];
    //             $test = "";
        
    //             foreach($form->getErrors(true) as $errors)
    //             {
    //                 if($test)
    //                 {
    //                     if( $test == $errors->getOrigin()->getName() )
    //                     {
    //                         $champ[] = $errors->getMessage();
    //                         dump("champ",$champ);
    //                     }
    //                     else
    //                     {
    //                         //dump($champ);
    //                         dump("error",$error[] = $champ);
    //                         $champ = [];
    //                         $test = $errors->getOrigin()->getName();
    //                         dump($champ[] = $errors->getOrigin()->getName());
    //                         dump($champ[] = $errors->getMessageTemplate());
    //                     }
    //                 }
    //                 else
    //                 {
    //                     $test = $errors->getOrigin()->getName();
    //                     dump($champ[] = $errors->getOrigin()->getName());
    //                     dump($champ[] = $errors->getMessage());
    //                 }
                    
                    
    //             }
        
    //             if($champ)
    //             {
    //                 $error[] = $champ;
    //             }
        
    //         // dump("errors",$error);
        
    //             // if($form->sSubmitted())
    //             // {
    //                     //  on envoie un mail ..
    //             // }
    //             //$form = $this->createForm(ContactType::class, $contact, ['action' => $url]);

            
    //             return $this->json('choucou');
    //             return $this->json($error);
        
    //         }
    //    }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView()
        ]);
    }


    

    /**
     * @Route("/fomulaire_ajax", name="formulaire_contact_ajax")
     */
    public function getSaveAnswersTokenAction(Request $request, ValidatorInterface $validator)
    {
       //$csrfProvider = $this->get('form.csrf_provider');
       $contact = new Contact();


    //    dump($request->request->all());
    //    dump($request->request->get("contact")["email"]);
    //    dd($request->request->get("contact[firstName]"));

       $form = $this->createForm(ContactType::class, $contact);

       //dump($request->request->get('firstName'));
       $data = json_decode($request->getContent(), true);

       $contact->setFirstName($data["contact[firstName]"])
                ->setLastName($data["contact[lastName]"])
                ->setEmail($data["contact[email]"])
                ->setCommentaire($data["contact[commentaire]"]);


        // $contact->setFirstName($request->request->get("contact")["firstName"])
        //         ->setLastName($request->request->get("contact")["lastName"])
        //         ->setEmail($request->request->get("contact")["email"])
        //         ->setCommentaire($request->request->get("contact")["commentaire"]);

                // $contact->setFirstName('m')
                // ->setLastName('lj')
                // ->setEmail('stephaneahoo.fr')
                // ->setCommentaire('mmmmmmmmmmmmmmm');
       
       // On récupère le validateur grâce au container de service
       //$validator = $this->get('validator');
       
       // On récupère la liste des erreurs de notre entité $user
       $liste_erreurs = $validator->validate($contact);

       $champ = "";
       $message = "";
       $champCopy = "";
       $champ_error = [];
       $errors = [];

       foreach( $liste_erreurs as $error)
       {
            //$error->getPropertyPath();
            $champ = $error->getPropertyPath();
            $message = $error->getMessage();
            // dump($error->getPropertyPath());
            // dump($error->getMessage());

            if ($champCopy == $champ)
            {
              $champ_error[] = $message;
            }
            else
            {
                $errors[] =  $champ_error;
                $champ_error = [];

                $champCopy = $champ;
                $champ_error[] = $champ;
                $champ_error[] = $message;
            }
            //$champ_error[] = $error->getMessage();

       }
       if($champ_error)
       {
            $errors[] =  $champ_error;
       }
       //$errors[] = $champ_error;

       array_shift($errors);
       dump($errors);
    //    dump($champ);
    //    dump($message);
    //    dump($errors);
       //dd($liste_erreurs);

      //return $this->json('toto');
       return $this->json($errors);

    //    $data = json_decode($request->getContent(), true);

    //    $form->submit($data);
    //         // dump($form->isSubmitted());
    //         // dump($form->isValid());
    //         //dump($form->isValid());

    //         //return $this->json(count($form->getErrors(true)));


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
                            // dump($champ[] = $errors->getOrigin()->getName());
                            // dump($champ[] = $errors->getMessageTemplate());
                        }
                    }
                    else
                    {
                        $test = $errors->getOrigin()->getName();
                        // dump($champ[] = $errors->getOrigin()->getName());
                        // dump($champ[] = $errors->getMessage());
                    }
                    
                    
                }
        
                if($champ)
                {
                    $error[] = $champ;
                }
               // $dataTest = json_encode($error);

                return $this->json(count($form->getErrors(true)));



    //            // return $this->json('token factice dans le controlleur get-token');

    //         if($form->isValid())
    //         {
    //             return $this->json(count($form->getErrors(true)));
    //             return $this->json($error);
    //             return $this->json('le formulaire est valide , enregistre fissa');
    //         }
    //         else{
    //             //return $this->json('le formulaire n est pas valide , blaireau');
    //             return $this->json($error);
                
    //         }
 

        // return new JsonResponse([
        //     'token' => $csrfProvider->generateCsrfToken('callcollection_form'),
        // ]);

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
