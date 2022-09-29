<?php

namespace WpStarter\Contracts\Auth;

interface Guard
{
    /**
     * Get the currently authenticated user.
     *
     * @return \WP_User|null
     */
    public function user();

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id();

}
