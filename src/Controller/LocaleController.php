<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LocaleController extends AbstractController
{
    #[Route('/change-locale/{locale}', name: 'app_change_locale')]
    public function change(string $locale, Request $request): Response
    {
        $request->getSession()->set('_locale', $locale);
        $referer = $request->headers->get('referer');

        return $this->redirect($this->generateUrl('app_home', ['_locale' => $locale]) ?: $referer);
    }
}
