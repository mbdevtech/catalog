<?php

namespace Application;

use Application\Controllers\CatalogController;
use DevNet\Web\Extensions\ApplicationBuilderExtensions;
use DevNet\Web\Extensions\ServiceCollectionExtensions;
use DevNet\Web\Hosting\WebHost;

class Program
{
    public static function main(array $args = [])
    {
        $builder = WebHost::createDefaultBuilder($args);
        $configuration = $builder->ConfigBuilder->build();

        $builder->configureServices(function ($services) {
            $services->addMvc();
            $services->addAntiforgery();
            $services->addAuthentication(function ($options) {
                $options->LoginPath = '/user/account/login';
            });
            $services->addAuthorisation();
        });

        $host = $builder->build();

        $host->start(function ($app) use ($configuration) {
            if ($configuration->getValue('environment') == 'development') {
                $app->UseExceptionHandler();
            } else {
                $app->UseExceptionHandler("/home/error");
            }

            $app->useRouter();
            $app->useAuthentication();
            $app->useAuthorization();

            $app->useEndpoint(function ($routes) {
                $routes->mapRoute("user", "/user/{controller=Account}/{action=Index}/{id?}");
                $routes->mapRoute("default", "{controller=Home}/{action=Index}/{id?}");
            });
        });
    }
}
