<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\Contracts\PollutantRepository::class, \App\Repositories\PollutantRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\RoleRepository::class, \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\DepartmentRepository::class, \App\Repositories\DepartmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\TechnicalValuesRepository::class, \App\Repositories\TechnicalValuesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\ResearchValuesRepository::class, \App\Repositories\ResearchValuesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\StatisticValuesRepository::class, \App\Repositories\StatisticValuesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\EmployeeRepository::class, \App\Repositories\EmployeeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\AqiCategoryRepository::class, \App\Repositories\AqiCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\RegionRepository::class, \App\Repositories\RegionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\LocationRepository::class, \App\Repositories\LocationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\ResourceRepository::class, \App\Repositories\ResourceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\PollutantValuesRepository::class, \App\Repositories\PollutantValuesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\AqiValuesRepository::class, \App\Repositories\AqiValuesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\QualityRepository::class, \App\Repositories\QualityRepositoryEloquent::class);
        //:end-bindings:
    }
}
