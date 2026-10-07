<?php

namespace App\Controller;

use App\Belgique\Culture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BelgiqueController extends AbstractController
{
    /**
     * En mode worker FrankenPHP, ce compteur survit entre les requêtes :
     * le processus PHP reste en mémoire, comme le Manneken Pis reste sur son socle.
     */
    private static int $fritesServies = 0;
    private static ?float $ouvertureFrietkot = null;

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        self::$ouvertureFrietkot ??= microtime(true);

        return $this->render('belgique/index.html.twig', [
            'sauces' => Culture::SAUCES,
            'bieres' => Culture::BIERES,
            'bd' => Culture::BD,
            'dico' => Culture::DICO,
            'slogan' => Culture::slogan(),
            'worker' => $this->workerStats(),
        ]);
    }

    #[Route('/api/frites', name: 'api_frites', methods: ['GET'])]
    public function frites(): JsonResponse
    {
        self::$ouvertureFrietkot ??= microtime(true);
        ++self::$fritesServies;

        return $this->json([
            'cornet' => 'grand',
            'sauce' => Culture::sauceAleatoire(),
            'slogan' => Culture::slogan(),
            'worker' => $this->workerStats(),
        ]);
    }

    #[Route('/api/belgique', name: 'api_belgique', methods: ['GET'])]
    public function belgique(): JsonResponse
    {
        return $this->json([
            'sauces' => Culture::SAUCES,
            'bieres' => Culture::BIERES,
            'bd' => Culture::BD,
            'dico' => Culture::DICO,
        ]);
    }

    private function workerStats(): array
    {
        return [
            'pid' => getmypid(),
            'frites_servies' => self::$fritesServies,
            'ouvert_depuis_s' => (int) round(microtime(true) - (self::$ouvertureFrietkot ?? microtime(true))),
            'mode_worker' => isset($_SERVER['FRANKENPHP_WORKER']) || \function_exists('frankenphp_handle_request'),
        ];
    }
}
