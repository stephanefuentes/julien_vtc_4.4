<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//use Symfony\Component\HttpFoundation\Response;



class AdminController extends AbstractController
{


    /**
     * @Route("/list_user", name="admin_list_user")
     */
    public function list_user(UserRepository $repo, Request $request)
    {


       if ($request->isXmlHttpRequest() )
        {
            $getUser = $request->query->get('user');

            if($getUser)
            {
                $list_user = $repo->findByUser($getUser);
            }
            else
            {
                $list_user = $repo->findBy([],['inscription_at' => 'desc']);
            }

            //dump($list_user);
            return $this->json($list_user, 200);
        }
         

        // $list_user = $repo->findBy([],['inscription_at' => 'desc']);

        // $list_user = $repo->findByUser("steph");
        // $list_user = $repo->findAll();
        $list_user = $repo->findBy([],['inscription_at' => 'desc']);


        return $this->render('admin/list_user2.html.twig', [
            'list_user' => $list_user
        ]);
    }



    /**
     * @Route("/edit_user/{id}", name="admin_edit_user")
     */
    public function edit_user(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserType::class, $user)
                        ->remove('password');

        $form->handleRequest($request);
        
        // dd($form->getData());
        
        if($form->isSubmitted() && $form->isValid())
        {
            
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_list_user');   
        }




        return $this->render("admin/edit_user.html.twig", [
                'form' => $form->createView()
        ]);
    } 


    
    /**
     * @Route("/delete_user/{id}", name="admin_delete_user")
     */
    public function delete_user(User $user, EntityManagerInterface $manager, Request $request)
    {
        // dd($user);
        
        if( $request->isXmlHttpRequest())
        {
            try
            {
                $manager->remove($user);
                $manager->flush();
    
                return $this->json('Suppression bien effectué en base de donnée', 200);
            }
            catch ( Exception $e)
            {
                return $this->json($e->getMessage());
                dd($e->getMessage());
            }
              
                        
         }

            
        try
        {
            $manager->remove($user);
            $manager->flush();

        }
        catch ( Exception $e)
        {
            
            dd($e->getMessage());
        }

        return $this->redirectToRoute('admin_list_user');

        // return $this->render("home/delete_user.html.twig", [

        // ]);
    }


    

}
