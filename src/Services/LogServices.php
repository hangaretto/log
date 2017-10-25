<?php

namespace Magnetar\Log\Services;

use Magnetar\Log\Models\Log;
use Magnetar\Mailing\Jobs\MailingJob;
use Mail;

class LogServices {

    /**
     * Create log.
     *
     * @param string $code
     * @param array $data
     * @return bool
     * @throws
     */
    public static function send($code, $data) {

        if(config('magnetar.log.templates.'.$code) == null)
            throw new \Exception('not.found.log_template');

        $reference = config('magnetar.log.templates.'.$code);

        if($reference['enabled'] != true)
            return false;

        $template = $reference['text'];
        foreach ($data as $key => $item)
            $template = str_replace(':'.$key, $item, $template);

        if(config('magnetar.log.levels.'.$reference['level']) == null)
            throw new \Exception('not.found.level');

        $level = config('magnetar.log.levels.'.$reference['level']);

        foreach ($level as $item) {

            switch ($item) {
                case 'admin_db':
                case 'user_db':
                    if($item == 'user_db' && !isset($data['user_id']))
                        throw new \Exception('log.validation.user_id');
                    $log = new Log();
                    $log->text = $template;
                    $log->code = $code;
                    $log->level = $reference['level'];
                    $log->data = json_encode($data);
                    $log->save();
                    break;
                case 'user_email':
                    if(!isset($data['email']))
                        throw new \Exception('log.validation.email');
                    $email_data['to'] = $data['email'];
                    $email_data['subject'] = 'Email log.';
                    $email_data['html'] = '<p>'.$template.'</p>';

                    dispatch(new MailingJob('email', $email_data));
                    break;
                case 'user_sms':
                    if(!isset($data['phone']))
                        throw new \Exception('log.validation.phone');
                    $sms_data['phone'] = $data['phone'];
                    $sms_data['text'] = $template;
                    $sms_data['driver'] = 'iq';

                    dispatch(new MailingJob('sms', $sms_data));
                    break;
                default:
                    if(substr_count($item, '@') > 0) {
                        $email_data['to'] = $item;
                        $email_data['subject'] = 'Email log.';
                        $email_data['html'] = '<p>'.$template.'</p>';

                        dispatch(new MailingJob('email', $email_data));
                    } else {
                        $sms_data['phone'] = $item;
                        $sms_data['text'] = $template;
                        $sms_data['driver'] = 'iq';

                        dispatch(new MailingJob('sms', $sms_data));
                    }
                    break;
            }

        }

        return true;
    }

}
