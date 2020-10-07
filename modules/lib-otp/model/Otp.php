<?php
/**
 * Otp
 * @package lib-otp
 * @version 0.0.1
 */

namespace LibOtp\Model;

class Otp extends \Mim\Model
{

    protected static $table = 'otp';

    protected static $chains = [];

    protected static $q = [];
}