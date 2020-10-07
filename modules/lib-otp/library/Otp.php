<?php
/**
 * Otp
 * @package lib-otp
 * @version 0.0.1
 */

namespace LibOtp\Library;

use LibOtp\Model\Otp as _Otp;

class Otp
{
    private static function expire(object $otp): bool{
        $expires = strtotime($otp->expires);
        if($expires > time())
            return false;

        $otp_set = [
            'status' => 0,
            'otp'    => time() . '#' . $otp->otp
        ];
        _Otp::set($otp_set, ['id'=>$otp->id]);

        return true;
    }

    static function generate(string $identity, int $len=6, string $expires='+2 hour'): string {
        // get exists if any
        $otp_ex = _Otp::getOne(['identity'=>$identity, 'status'=>1]);
        if($otp_ex && !self::expire($otp_ex)){
            $otp_ex_set = [
                'expires' => date('Y-m-d H:i:s', strtotime($expires))
            ];
            _Otp::set($otp_ex_set, ['id'=>$otp_ex->id]);

            return $otp_ex->otp;
        }

        $otp_cr = [
            'identity' => $identity,
            'otp'      => null,
            'expires'  => date('Y-m-d H:i:s', strtotime($expires))
        ];

        $rn_start = '1' . str_repeat('0', $len-1);
        $rn_end   = '9' . str_repeat('9', $len-1);

        while(true){
            $otp = rand($rn_start, $rn_end);

            if($e_otp = _Otp::getOne(['otp'=>$otp])){
                self::expire($e_otp);
                continue;
            }

            $otp_cr['otp'] = $otp;
            break;
        }

        _Otp::create($otp_cr);
        return $otp_cr['otp'];
    }

    static function validate(string $identity, string $otp): bool {
        $e_otp = _Otp::getOne(['identity'=>$identity, 'otp'=>$otp]);
        if(!$e_otp)
            return false;

        if($e_otp->status != 1)
            return false;

        if(self::expire($e_otp))
            return false;

        $otp_set = [
            'otp'       => time() . '#' . $e_otp->otp,
            'status'    => 2,
            'validated' => date('Y-m-d H:i:s')
        ];
        _Otp::set($otp_set, ['id'=>$e_otp->id]);

        return true;
    }
}