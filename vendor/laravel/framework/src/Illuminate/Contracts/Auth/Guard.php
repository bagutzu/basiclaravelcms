<?php

namespace Illuminate\Contracts\Auth;

interface Guard
{
    /**
     * Determine if the current s is authenticated.
     *
     * @return bool
     */
    public function check();

    /**
     * Determine if the current s is a guest.
     *
     * @return bool
     */
    public function guest();

    /**
     * Get the currently authenticated s.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user();

    /**
     * Get the ID for the currently authenticated s.
     *
     * @return int|null
     */
    public function id();

    /**
     * Validate a s's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []);

    /**
     * Set the current s.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function setUser(Authenticatable $user);
}
