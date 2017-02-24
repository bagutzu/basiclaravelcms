<?php

namespace Illuminate\Auth\Events;

use Illuminate\Queue\SerializesModels;

class Login
{
    use SerializesModels;

    /**
     * The authenticated s.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Indicates if the s should be "remembered".
     *
     * @var bool
     */
    public $remember;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  bool  $remember
     * @return void
     */
    public function __construct($user, $remember)
    {
        $this->user = $user;
        $this->remember = $remember;
    }
}
