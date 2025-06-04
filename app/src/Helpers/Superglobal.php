<?php
namespace App\Helpers;

class Superglobal
{
    private $_SERVER;
    private $_POST;
    private $_GET;
    private $_SESSION;
    private $_FILES;
    private $_ENV;

    public function __construct()
    {
        $this->define_superglobal();
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     */
    public function get_SERVER($key = null): mixed
    {
        if (null !== $key) {
            return (isset($this->_SERVER["$key"])) ? $this->_SERVER["$key"] : null;
        } else {
            return $this->_SERVER;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     */
    public function get_POST($key = null): mixed
    {
        if (null !== $key) {
            return (isset($this->_POST["$key"])) ? $this->_POST["$key"] : null;
        } else {
            return $this->_POST;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     */
    public function get_GET($key = null): mixed
    {
        if (null !== $key) {
            return (isset($this->_GET["$key"])) ? $this->_GET["$key"] : null;
        } else {
            return $this->_GET;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     */
    public function get_SESSION($key = null): mixed
    {
        if (null !== $key) {
            return (isset($this->_SESSION["$key"])) ? $this->_SESSION["$key"] : null;
        } else {
            return $this->_SESSION;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     */
    public function get_FILES($key = null): mixed
    {
        if (null !== $key) {
            return (isset($this->_FILES["$key"])) ? $this->_FILES["$key"] : null;
        } else {
            return $this->_FILES;
        }
    }

    /**
     * Returns a key from the superglobal,
     * as it was at the time of instantiation.
     */
    public function get_ENV($key = null): mixed
    {
        if (null !== $key) {
            return (isset($this->_ENV["$key"])) ? $this->_ENV["$key"] : null;
        } else {
            return $this->_ENV;
        }
    }

    /**
     * Function to define superglobal for use locally.
     * We do not automatically unset the superglobal after
     * defining them, since they might be used by other code.
     */
    private function define_superglobal(): void
    {
        // Store a local copy of the PHP superglobal
        // This should avoid dealing with the global scope directly
        // $this->_SERVER = $_SERVER;
        $this->_SERVER = (isset($_SERVER)) ? $_SERVER : null;
        $this->_POST = (isset($_POST)) ? $_POST : null;
        $this->_GET = (isset($_GET)) ? $_GET : null;
        $this->_SESSION = (isset($_SESSION)) ? $_SESSION : null;
        $this->_FILES = (isset($_FILES)) ? $_FILES : null;
        $this->_ENV = (isset($_ENV)) ? $_ENV : null;

    }
    
    /**
     * You may call this function from your compositioning root,
     * if you are sure superglobal will not be needed by
     * dependencies or outside of your own code.
     */
    public function unset_superglobal(): void
    {
        unset($_SERVER);
        unset($_POST);
        unset($_GET);
        unset($_SESSION);
        unset($_FILES);
        unset($_ENV);
    }

}