<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Context\Common\Application\Service\User\Query\ViewUserQuery;
use App\Context\Common\Application\Service\User\UserServiceInterface;
use Illuminate\Console\Command;

class ViewUserConsoleCommand extends Command
{
    protected $signature = 'user:view {id}';

    protected $description = 'View user';

    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var int $id */
        $id = $this->argument('id');

        $query = new ViewUserQuery($id);

        $userDto = $this->userService->view($query);

        $this->line('user name: ' . $userDto->name);

        return 0;
    }
}
