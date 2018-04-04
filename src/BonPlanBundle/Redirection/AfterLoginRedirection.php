<?php
/**
 * Created by PhpStorm.
 * User: ramyk
 * Date: 2/9/2018
 * Time: 1:11 PM
 */

namespace BonPlanBundle\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
// Get list of roles for current user
        $roles = $token->getRoles();
// Tranform this list in array
        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);
// If is a admin or super admin we redirect to the backoffice area
        if (in_array('ROLE_PROPRIETAIRE', $rolesTab, true))

            $redirection = new RedirectResponse($this->router->generate('bon_plan_accueilProp'));

// otherwise we redirect user to the member area
        else

            if (in_array('ROLE_CLIENT', $rolesTab, true))

                $redirection = new RedirectResponse($this->router->generate('bon_plan_accueilClient'));
            else
                    $redirection = new RedirectResponse($this->router->generate('bon_plan_accueilAdmin'));

        return $redirection;

    }
}