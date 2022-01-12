<?php

namespace src;

use DateTime;

class OnboardingDataEntity    {
    
    public int $user_id;

    public DateTime $created_at;

    public int $onboarding_percentage;

    public int $count_applications;

    public int $count_accepted_applications;


    public function __construct(int $user_id, DateTime $created_at, int $onboarding_percentage, int $count_applications, int $count_accepted_applications)  
    {
        $this->user_id = $user_id;
        $this->created_at = $created_at;
        $this->onboarding_percentage = $onboarding_percentage;
        $this->count_applications = $count_applications;
        $this->count_accepted_applications = $count_accepted_applications;
    }
}