<?php

namespace App\Actions;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogAction
{
    /**
     * Log an action.
     *
     * @param string $action The action being performed (e.g., 'login', 'website.updated')
     * @param Model|null $model The model that was affected (optional)
     * @param array|null $changes Array of changes ['field' => ['old' => value, 'new' => value]]
     * @param string|null $description Human-readable description
     * @return Log
     */
    public function execute(
        string $action,
        ?Model $model = null,
        ?array $changes = null,
        ?string $description = null
    ): Log {
        $user = Auth::user();
        
        // If no description provided, generate one
        if (!$description) {
            $description = $this->generateDescription($action, $model);
        }

        return Log::create([
            'user_id' => $user?->id,
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'changes' => $changes,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Generate a human-readable description from the action and model.
     */
    private function generateDescription(string $action, ?Model $model): string
    {
        $user = Auth::user();
        $userName = $user ? $user->full_name : 'System';
        
        $actionMap = [
            'login' => 'logged in',
            'website.created' => 'created website',
            'website.updated' => 'updated website',
            'website.deleted' => 'deleted website',
            'page.created' => 'created page',
            'page.updated' => 'updated page',
            'page.deleted' => 'deleted page',
            'menu_item.created' => 'created menu item',
            'menu_item.updated' => 'updated menu item',
            'menu_item.deleted' => 'deleted menu item',
        ];

        $actionText = $actionMap[$action] ?? $action;
        
        if ($model) {
            $modelName = $this->getModelName($model);
            return "{$userName} {$actionText} \"{$modelName}\"";
        }

        return "{$userName} {$actionText}";
    }

    /**
     * Get a human-readable name for the model.
     */
    private function getModelName(Model $model): string
    {
        // Try common name fields
        if (isset($model->name)) {
            return $model->name;
        }
        if (isset($model->title)) {
            return $model->title;
        }
        if (isset($model->email)) {
            return $model->email;
        }
        
        // Fallback to class name and ID
        $className = class_basename($model);
        return "{$className} #{$model->id}";
    }

    /**
     * Log a user login.
     */
    public function logLogin(): Log
    {
        return $this->execute('login');
    }

    /**
     * Log a model update with changes.
     */
    public function logUpdate(Model $model, array $originalAttributes = []): Log
    {
        $changes = [];
        $dirty = $model->getDirty();
        
        foreach ($dirty as $key => $newValue) {
            $oldValue = $originalAttributes[$key] ?? $model->getOriginal($key);
            if ($oldValue != $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        $action = $this->getActionForModel($model, 'updated');
        
        return $this->execute($action, $model, $changes);
    }

    /**
     * Log a model creation.
     */
    public function logCreate(Model $model): Log
    {
        $action = $this->getActionForModel($model, 'created');
        return $this->execute($action, $model);
    }

    /**
     * Log a model deletion.
     */
    public function logDelete(Model $model): Log
    {
        $action = $this->getActionForModel($model, 'deleted');
        return $this->execute($action, $model);
    }

    /**
     * Get the action string for a model type.
     */
    private function getActionForModel(Model $model, string $event): string
    {
        $modelType = class_basename($model);
        $modelType = strtolower($modelType);
        
        // Handle special cases
        if ($modelType === 'menuitem') {
            $modelType = 'menu_item';
        }
        
        return "{$modelType}.{$event}";
    }
}
