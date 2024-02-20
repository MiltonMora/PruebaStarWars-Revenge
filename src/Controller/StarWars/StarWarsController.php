<?php

namespace App\Controller\StarWars;

use App\Application\StarWars\Command\GetCharacterByIdCommand;
use App\Application\StarWars\Command\ListCharactersCommand;
use App\Controller\AbstractGeneralController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/star-wars')]
class StarWarsController extends AbstractGeneralController
{
    #[Route('/show', name: 'show_star_wars')]
    public function show(Request $request): Response
    {
        $data = $this->commandBus->handle(new ListCharactersCommand($request->get('characterName')));
        return $this->render('star_wars/index.html.twig', [
            'controller_name' => 'StarWarsController',
            'data' => $data
        ]);
    }
    #[Route('/show/{id}', name: 'app_star_wars')]
    public function showOneById(Request $request, int $id): Response
    {
        $data = $this->commandBus->handle(new GetCharacterByIdCommand($id));
        return $this->render('star_wars/OneById.html.twig', [
            'controller_name' => 'StarWarsController',
            'character' => $data
        ]);
    }
}
