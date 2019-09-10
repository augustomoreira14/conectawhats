<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Store;

use App\Events\StoreActivated;
use App\Events\StoreCreated;
use App\Events\StoreDeactivated;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Store
 *
 * @author augus
 */
class Store extends Model
{
    protected $table = 'stores';
    protected $fillable = [
        'shop', 'token', 'plan', 'type', 'user_id', 'actived'
    ];

    protected $dispatchesEvents = [
        'created' => StoreCreated::class
    ];

    public function associateUser($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getPlanAttribute($value)
    {
        if(!$value instanceof Plan){
            $value = Plan::createByJson($value);
        }

        return $value;
    }

    public function inTrialDays()
    {
        return $this->created_at->addDays($this->plan->trial_days) >= now();
    }

    public function isActived()
    {
        return $this->actived;
    }

    public function activate()
    {
        if (!$this->isActived()) {
            $this->actived = true;
            event(new StoreActivated($this));
        }
    }

    public function deactivate()
    {
        if ($this->isActived()) {
            $this->actived = false;
            event(new StoreDeactivated($this));
        }
    }
}
