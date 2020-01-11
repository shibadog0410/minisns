<?php
class Session
{
    protected static $sessionStarted = FALSE;
    protected static $sessionIdRegenerated = FALSE;

    public function __construct()
    {
        if (!self::$sessionStarted) {
            session_start();
            self::$sessionStarted = TRUE;
        }
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name, $default = NULL)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $default;
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    public function clear()
    {
        $_SESSION = array();
    }

    public function regenerate($destroy = TRUE)
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id($destroy);
            self::$sessionIdRegenerated = TRUE;
        }
    }

    public function setAuthenticated($bool)
    {
        $this->set('_authenticated', (bool) $bool);
        $this->regenerate();
    }

    public function isAuthenticated()
    {
        return $this->get('_authenticated', FALSE);
    }
}
