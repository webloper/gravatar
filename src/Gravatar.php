<?php

/**
 * Gravatar Class
 *
 * @package   Gravatar
 * @author    Ravi Kumar
 * @version   0.1.0
 * @copyright Copyright (c) 2014, Ravi Kumar
 * @license   https: //github.com/webloper/gravatar/blob/master/LICENSE MIT
 **/

namespace Webloper\Gravatar;

use Webloper\Gravatar\Exception\EmailRequiredException;
use Webloper\Gravatar\Exception\InvalidEmailException;
use Webloper\Gravatar\Exception\InvalidFormatException;

class Gravatar
{
    /** @var string */
    private $base_url = 'http://www.gravatar.com/';

    /** @var string */
    private $base_url_secure = 'https://secure.gravatar.com/';

    /** @var array */
    private $options = [];

    /** @var string */
    protected $email_hash = 'null';

    /**
     * Constructor
     *
     * @param string email
     **/
    public function __construct(string $email = null)
    {
        if (is_null($email)) {
            throw new EmailRequiredException();
        }

        $email = strtolower(trim($email));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        $this->email_hash = hash('md5', $email);
    }

    /**
     * url
     *
     * @param  bool true if secure else false
     * @param  string extension for image file
     * @return string url of the gravatar
     **/
    public function url(bool $secure = false, string $extension = null)
    {
        if ($secure) {
            $result = $this->base_url_secure;
        } else {
            $result = $this->base_url;
        }

        if (! is_null($extension) && in_array($extension, ['jpg', 'png'])) {
            $result .= 'avatar/' . $this->email_hash . '.' . $extension;
        } else {
            $result .= 'avatar/' . $this->email_hash;
        }

        if (! empty($this->options)) {
            $result .= '?' . http_build_query($this->options);
        }

        return $result;
    }

    /**
     * img
     *
     * @param  array image attributes in key/value
     * @param  bool true if secure else false
     * @return string url of the gravatar with html img tag
     **/
    public function img(array $attrs = [], bool $secure = false)
    {
        $result = '<img src="' . $this->url($secure) . '"';

        foreach ($attrs as $key => $val) {
            $result .= ' ' . $key . '="' . $val . '"';
        }
        $result .= ' />';

        return $result;
    }

    /**
     * profile
     *
     * @param  string format supported php, json, qr, vcf, and xml
     * @return mixed
     **/
    public function profile(string $format = 'php')
    {
        $format = strtolower(trim($format));
        $default_format = ['json', 'xml', 'php', 'vcf', 'qr'];

        if (! in_array($format, $default_format)) {
            throw new InvalidFormatException();
        }

        switch ($format) {
            case 'json':

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $this->base_url . $this->email_hash . '.' . $format);
                $data = curl_exec($ch);
                curl_close($ch);

                return $data;

            case 'xml':

                return simplexml_load_string(file_get_contents($this->base_url . $this->email_hash . '.' . $format));

            case 'php':

                return unserialize(file_get_contents($this->base_url . $this->email_hash . '.' . $format));

            case 'vcf':

                return $this->base_url . $this->email_hash . '.' . $format;

            case 'qr':

                $result = $this->base_url . $this->email_hash . '.' . $format;

                if (! empty($this->options)) {
                    $result .= '?' . http_build_query($this->options);
                }

                return $result;
        }
    }

    /**
     * __call
     *
     * @param string method name
     * @param array arguments
     **/
    public function __call(string $method, array $arguments)
    {
        $default_methods = ['setSize', 'setRating', 'setDefault', 'setForceDefault'];

        if (in_array($method, $default_methods)) {
            switch ($method) {

                case 'setSize':

                    $this->options['s'] = $arguments[0];

                    break;

                case 'setRating':

                    $this->options['r'] = $arguments[0];

                    break;

                case 'setForceDefault':

                    $this->options['f'] = $arguments[0];

                // no break
                case 'setDefault':

                    $this->options['d'] = urlencode($arguments[0]);

                    break;
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->base_url . 'avatar/' . $this->email_hash;
    }
} // END class Gravatar
