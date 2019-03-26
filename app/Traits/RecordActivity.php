<?php


namespace App\Traits;


use App\Activity;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        if (auth()->guest()) return;
        foreach (static::getRecordEvents() as $event)
        {
            static::$event(function ($model) use ($event) {
                $model->getRecordActivity($event);
            });
        }
        static::deleting(function ($model) {
            $model->activities()->delete();
        });
    }

    protected static function getRecordEvents()
    {
        return ['created'];
    }
    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }

    protected function getRecordActivity($event)
    {
        $this->activities()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
