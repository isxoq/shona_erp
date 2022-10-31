<?php

namespace api\components;
# User: isxoq
# Date: 03.10.2021
# Time: 9:30
# Year: 2021
# Project: tashxis.loc
# Full Name: Isxoqjon Axmedov
# Phone: +998936448111

class Error extends \yii\base\Component
{
    const SUCCESS = 200;
    const SMS_ALREADY_SENT = 477;
    const USER_IMAGE_ERROR = 665;
    const UNKNOWN_ERROR = 520;
    const VALIDATION_ERROR = 409;
    const INVALID_UPLOAD_TYPE = 415;
    const DONT_HAVE_PERMISSION = 407;
    const NOT_FOUND = 404;
    const ALREADY_EXISTS = 450;
    const SMS_SEND_FAILED = 460;
    const TOO_MANY_ATTEMPTS = 429;
    const OTP_EXPIRED = 461;
    const INVALID_OTP = 462;
    const FILE_DOES_NOT_EXIST = 463;
    const CLIENT_NOT_FOUND = 4040;
    const CLIENT_ALREADY_EXIST = 4010;

    public static function errors(): array
    {
        return [
            self::SUCCESS => \Yii::t('app', 'Success'),
            self::SMS_ALREADY_SENT => \Yii::t('app', 'SMS already send'),
            self::UNKNOWN_ERROR => \Yii::t('app', 'Aniqlanmagan xatolik'),
            self::VALIDATION_ERROR => \Yii::t('app', 'Validation Error'),
            self::INVALID_UPLOAD_TYPE => \Yii::t('app', 'Upload type Error'),
            self::DONT_HAVE_PERMISSION => \Yii::t('app', 'Permission Error'),
            self::NOT_FOUND => \Yii::t('app', 'Not Found'),
            self::ALREADY_EXISTS => \Yii::t('app', 'Already Exist'),
            self::SMS_SEND_FAILED => \Yii::t('app', 'SMS send failed'),
            self::TOO_MANY_ATTEMPTS => \Yii::t('app', 'Too many Attempts'),
            self::OTP_EXPIRED => \Yii::t('app', 'OTP expired'),
            self::INVALID_OTP => \Yii::t('app', 'Invalid OTP'),
            self::FILE_DOES_NOT_EXIST => \Yii::t('app', 'File doesnot exist'),
            self::CLIENT_NOT_FOUND => \Yii::t('app', 'CLIENT Not found'),
            self::CLIENT_ALREADY_EXIST => \Yii::t('app', 'Client already exists'),
        ];
    }

    public static function getErrorMessage($code)
    {
        return self::errors()[$code];
    }


}