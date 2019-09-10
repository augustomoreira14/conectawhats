<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Store;

use App\ConectaWhats\SideDish\ObjectValue;
use Carbon\Carbon;

/**
 * Description of Plan
 *
 * @author augus
 */
class Plan extends ObjectValue
{
    const PLAN1 = 'plan1';
    const PLAN2 = 'plan2';
    const TEST = 'test';

    private $name;
    private $trial_days;
    private $price;
    private $test;

    public function __construct($name, $trial_days, $price, $test = false)
    {
        $this->name = $name;
        $this->trial_days = $trial_days;
        $this->price = (double) $price;
        $this->test = $test;
    }

    public function discountDays(Carbon $date)
    {
        $newPlan = clone $this;

        $now = Carbon::now($date->timezone);
        $days = $now->diffInDays($date->addDays($this->trial_days), false);
        $newPlan->trial_days = $days > 0 ? $days : 0;

        return $newPlan;
    }

    public static function createByJson($string)
    {
        $planDTO = json_decode($string);

        return new Plan(
            $planDTO->name,
            $planDTO->trial_days,
            $planDTO->price,
            $planDTO->test
        );
    }

    public static function create($id)
    {
        $plan = self::searchPlan($id);

        if(!$plan){
            throw new \InvalidArgumentException("Plan {$id} dont exists.");
        }

        return new Plan(
            $plan['name'],
            $plan['trial_days'],
            $plan['price'],
            $plan['test']
        );
    }
    
    protected static function searchPlan($id)
    {
        $key = array_search($id, array_column(self::plans(), 'id'));
        if($key !== false){
            return self::plans()[$key];
        }
    }

    public static function plans()
    {
        return [
            [
                'id' => self::TEST,
                'name' => 'Plano Teste',
                'trial_days' => null,
                'price' => 0.01,
                'test' => true
            ],
            [
                'id' => self::PLAN1,
                'name' => 'Plano Beta',
                'trial_days' => 15,
                'price' => 7.00,
                'test' => false
            ],
            [
                'id' => self::PLAN2,
                'name' => 'Plano Básico',
                'trial_days' => 7,
                'price' => 10.00,
                'test' => false
            ],
        ];
    }

    public function __toString() 
    {
        return "{$this->toJson()}";
    }
}
