<?php

namespace Osen\Permission;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Guard
{
    /**
     * Return a collection of guard names suitable for the $model,
     * as indicated by the presence of a $guard_name property or a guardName() method on the model.
     *
     * @param  string|Model  $model  model class object or name
     */
    public static function getNames($model): Collection
    {
        $class = is_object($model) ? get_class($model) : $model;

        if (is_object($model)) {
            if (\method_exists($model, 'guardName')) {
                $guardName = $model->guardName();
            } else {
                $guardName = $model->getAttributeValue('guard_name');
            }
        }

        if (! isset($guardName)) {
            $guardName = (new \ReflectionClass($class))->getDefaultProperties()['guard_name'] ?? null;
        }

        if ($guardName) {
            return collect($guardName);
        }

        return self::getConfigAuthGuards($class);
    }

    /**
     * Get the model class associated with a given provider.
     */
    protected static function getProviderModel(string $provider): ?string
    {
        // Get the provider configuration
        $providerConfig = config("auth.providers.{$provider}");

        // Handle LDAP provider or standard Eloquent provider
        if (isset($providerConfig['driver']) && $providerConfig['driver'] === 'ldap') {
            return $providerConfig['database']['model'] ?? null;
        }

        return $providerConfig['model'] ?? null;
    }

    /**
     * Get list of relevant guards for the $class model based on config(auth) settings.
     *
     * Lookup flow:
     * - get names of models for guards defined in auth.guards where a provider is set
     * - filter for provider models matching the model $class being checked (important for Lumen)
     * - keys() gives just the names of the matched guards
     * - return collection of guard names
     */
    protected static function getConfigAuthGuards(string $class): Collection
    {
        return collect(config('auth.guards'))
            ->map(function ($guard) {
                if (! isset($guard['provider'])) {
                    return null;
                }

                return static::getProviderModel($guard['provider']);
            })
            ->filter(fn ($model) => $class === $model)
            ->keys();
    }

    /**
     * Get the model associated with a given guard name.
     */
    public static function getModelForGuard(string $guard): ?string
    {
        // Get the provider configuration for the given guard
        $provider = config("auth.guards.{$guard}.provider");

        if (! $provider) {
            return null;
        }

        return static::getProviderModel($provider);
    }

    /**
     * Lookup a guard name relevant for the $class model and the current user.
     *
     * @param  string|Model  $class  model class object or name
     * @return string guard name
     */
    public static function getDefaultName($class): string
    {
        $default = config('auth.defaults.guard');

        $possible_guards = static::getNames($class);

        // return current-detected auth.defaults.guard if it matches one of those that have been checked
        if ($possible_guards->contains($default)) {
            return $default;
        }

        return $possible_guards->first() ?: $default;
    }

    /**
     * Lookup a passport guard
     */
    public static function getPassportClient($guard): ?Authorizable
    {
        $guards = collect(config('auth.guards'))->where('driver', 'passport');

        if (! $guards->count()) {
            return null;
        }

        $authGuard = Auth::guard($guards->keys()[0]);

        if (! \method_exists($authGuard, 'client')) {
            return null;
        }

        $client = $authGuard->client();

        if (! $guard || ! $client) {
            return $client;
        }

        if (self::getNames($client)->contains($guard)) {
            return $client;
        }

        return null;
    }
}
