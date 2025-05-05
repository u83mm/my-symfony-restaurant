<?php

// src/Controller/LocaleController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocaleController extends AbstractController
{        
    public function __construct(
        private array $supportedLocales = ['en', 'es'], // Inject supported locales
    )
    {       
    }

    #[Route('/change-locale/{locale}', name: 'app_change_locale')]
    public function change(string $locale, Request $request): Response
    {
        // Validate the requested locale
        if (!in_array($locale, $this->supportedLocales)) {
            $locale = $this->getParameter('kernel.default_locale');
        }

        // Store the locale in the session
        $request->getSession()->set('_locale', $locale);

        // Try to get the referer URL
        $referer = $request->headers->get('referer');
        
        if ($referer) {
            // Parse the referer URL to maintain the new locale
            $refererPath = parse_url($referer, PHP_URL_PATH);
            
            // Check if the referer already has a locale prefix
            $hasLocale = false;
            foreach ($this->supportedLocales as $supportedLocale) {
                if (str_starts_with($refererPath, "/$supportedLocale/") || 
                    $refererPath === "/$supportedLocale") {
                    $hasLocale = true;
                    break;
                }
            }
            
            if ($hasLocale) {
                // Replace the locale in the referer URL
                $newReferer = preg_replace(
                    '~^/([a-z]{2})(/|$)~', 
                    "/$locale$2", 
                    $refererPath
                );
                return $this->redirect($newReferer);
            }
        }
        
        // Fallback to the homepage with the new locale
        return $this->redirectToRoute('app_home', ['_locale' => $locale]);
    }
}