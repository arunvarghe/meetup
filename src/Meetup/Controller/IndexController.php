<?php
declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Form\Type\MatchFormType;
use Meetup\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private ServiceInterface $service;

    public function __construct(
        ServiceInterface $service
    ) {
        $this->service = $service;
    }

    /**
     * @Route("/")
     */
    public function index(Request $request): Response
    {
        $list = [];
        $form = $this->createForm(MatchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $list = $this->service->get();
        }

        return $this->renderForm('@Twig/index/index.html.twig', [
            'form' => $form,
            'isFromSubmitted' => $form->isSubmitted(),
            'list' => $list
        ]);
    }
}
