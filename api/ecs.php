<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        Option::PATHS,
        [
            'config',
            'database',
            'public',
            'ecs.php',
            'app',
            'bootstrap',
            'tests',
            'resources',
            'routes',
            'server.php',
        ]
    );
    $parameters->set(
        Option::SKIP,
        [
            'tests/_support/_generated/*',
            'bootstrap/cache/*',
            // example: if(!$bar){} => if(! $bar){}
            NotOperatorWithSuccessorSpaceFixer::class => '~',
            // example: (string)$var => (string) $var
            CastSpacesFixer::class => '~',
            \PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer::class => '~',
        ]
    );
    $parameters->set(
        Option::SETS,
        [
            SetList::ARRAY,
            SetList::PHP_70,
            SetList::PHP_71,
            SetList::CLEAN_CODE,
            SetList::PSR_12,
            SetList::NAMESPACES,
            SetList::DOCBLOCK,
            SetList::SPACES,
            SetList::COMMENTS,
        ]
    );
    $parameters->set(
        Option::FILE_EXTENSIONS,
        [
            'php',
        ]
    );
};
