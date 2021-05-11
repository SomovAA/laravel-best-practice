<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Service;

use App\Context\Common\Application\Service\User\Command\CreateUserCommand;
use App\Context\Common\Application\Service\User\Query\ViewUserQuery;
use App\Context\Common\Application\Service\User\UserServiceInterface;
use App\Http\Controllers\Api\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends AbstractController
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function create(Request $request): JsonResponse
    {
        /** @var string $name */
        $name = $request->post('name');
        /** @var string $email */
        $email = $request->post('email');
        /** @var string $password */
        $password = $request->post('password');
        // здесь должна быть простая валидация, если не проходит, то возвращаю ответ

        $command = new CreateUserCommand($name, $email, $password);

        $this->userService->create($command);

        return new JsonResponse();
    }

    public function view(Request $request): JsonResponse
    {
        /** @var int $id */
        $id = $request->query('id');
        // здесь должна быть простая валидация, если не проходит, то возвращаю ответ

        $query = new ViewUserQuery($id);

        $userDto = $this->userService->view($query);

        return new JsonResponse([
            'name' => $userDto->name,
        ]);
    }
}
