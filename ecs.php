<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(OrderedImportsFixer::class)->call(
        'configure',
        [
            [
                'imports_order' => [
                    OrderedImportsFixer::IMPORT_TYPE_CLASS,
                    OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
                    OrderedImportsFixer::IMPORT_TYPE_CONST
                ]
            ]
        ]
    );

    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        Option::PATHS,
        [
            'src',
            'tests'
        ]
    );

    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::SYMFONY);
    $containerConfigurator->import(SetList::SYMFONY_RISKY);
};
