<?php
/**
 * Otp
 * @package lib-otp
 * @version 1.1.0
 */

namespace LibOtp\Library;

use LibOtp\Model\Otp as _Otp;

class Otp
{
    private static function expire(object $otp): bool
    {
        $expires = strtotime($otp->expires);
        if ($expires > time()) {
            return false;
        }

        $otp_set = [
            'status' => 0,
            'otp'    => time() . '#' . $otp->otp
        ];
        _Otp::set($otp_set, ['id'=>$otp->id]);

        return true;
    }

    public static function generate(
        string $identity,
        int $len = 6,
        string $expires = '+2 hour',
        string $retry = '+60 seconds'
    ): object {
        $cond = [
            'identity' => $identity,
            'status' => 1
        ];

        $ex_otp = _Otp::getOne($cond);
        if ($ex_otp && !self::expire($ex_otp)) {
            // Update expiration time
            $ex_otp_set = [
                'expires' => date('Y-m-d H:i:s', strtotime($expires))
            ];

            // If retry count is less then now, reset the timer
            $t_retry = strtotime($ex_otp->retry);
            if ($t_retry <= time()) {
                $ex_otp_set['retry'] = date('Y-m-d H:i:s', strtotime($retry));
            }

            _Otp::set($ex_otp_set, ['id' => $ex_otp->id]);
            $ex_otp = _Otp::getOne(['id' => $ex_otp->id]);
            return $ex_otp;
        }

        $otp_cr = [
            'identity' => $identity,
            'otp'      => null,
            'expires'  => date('Y-m-d H:i:s', strtotime($expires)),
            'retry'    => date('Y-m-d H:i:s', strtotime($retry))
        ];

        $rn_start = '1' . str_repeat('0', $len-1);
        $rn_end   = '9' . str_repeat('9', $len-1);

        while (true) {
            $otp = rand($rn_start, $rn_end);

            if ($e_otp = _Otp::getOne(['otp'=>$otp])) {
                self::expire($e_otp);
                continue;
            }

            $otp_cr['otp'] = $otp;
            break;
        }

        $id = _Otp::create($otp_cr);
        $otp_cr = _Otp::getOne(['id' => $id]);
        return $otp_cr;
    }

    public static function validate(string $identity, string $otp): bool
    {
        $e_otp = _Otp::getOne(['identity'=>$identity, 'otp'=>$otp]);
        if (!$e_otp) {
            return false;
        }

        if ($e_otp->status != 1) {
            return false;
        }

        if (self::expire($e_otp)) {
            return false;
        }

        $otp_set = [
            'otp'       => time() . '#' . $e_otp->otp,
            'status'    => 2,
            'validated' => date('Y-m-d H:i:s')
        ];
        _Otp::set($otp_set, ['id'=>$e_otp->id]);

        return true;
    }
}
