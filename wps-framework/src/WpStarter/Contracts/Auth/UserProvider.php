<?php

namespace WpStarter\Contracts\Auth;

interface UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \WP_User|null
     */
    public function retrieveById($identifier);
}
