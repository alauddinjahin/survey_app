<?php

namespace Pondit\Authorize\Models;

trait Authorizable
{

    public static function bootAuthorizable()
    {
        static::loaded( function ($model) {
            $model->fillable[] = 'role_id';
        });
    }

    /**
     * @inheritdoc
     */
    public function newFromBuilder($attributes = array(), $connection = NULL)
    {
        $instance = parent::newFromBuilder($attributes);

        $instance->fireModelEvent('loaded');

        return $instance;
    }

    /**
     * Register a loaded model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param  int  $priority
     * @return void
     */
    public static function loaded($callback, $priority = 0)
    {
        static::registerModelEvent('loaded', $callback, $priority);
    }

    public function isAuthorize($namespace, $controller, $method, $action)
    {
        if(is_null($this->role_id)) {
            return false;
        }

        $permission = $this->role->permissions
            ->where('namespace', $namespace)
            ->where('controller', $controller)
            ->where('method', $method)
            ->where('action', $action);
        if (count($permission) > 0) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->role_id == "1" ? true : false;
    }

    /**
     * Get the type of the user.
     */
    public function role()
    {
        return $this->belongsTo('Pondit\Authorize\Models\Role');
    }
}
