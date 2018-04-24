<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $name
     */
    public function register(Request $request)
    {$user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            $roleRepository = $this->getDoctrine()->getRepository(Role::class);
            $userRole = $roleRepository->findOneBy(['name' => 'ROLE_USER']);
            $user->setRoles([$userRole]);
            $hash = password_hash($user->getPassword(),PASSWORD_BCRYPT);
            $user->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("login");
        }

        return $this->render("user/register.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $utils){

        return $this->render("user/login.html.twig",  ['error' => $utils->getLastAuthenticationError()]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }

    /**
     * @Route("/user/profile", name="user_profile")
     * @Security("has_role('ROLE_USER')")
     */
    public function showProfile(){
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $this->getUser()->getUsername()]);

        return $this->render("user/profileInfo.html.twig", ["user" => $user]);
    }

    /**
     * @Route("/users/profile/{id}", name="profile_by_id")
     * @Security("has_role('ROLE_USER')")
     */
    public function showProfileById(int $id){
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($id);

        return $this->render("user/profileById.html.twig", ['user' => $user]);
    }

    /**
     * @Route("/test")
     */
    public function test(){
        echo "test";die();
    }
}
