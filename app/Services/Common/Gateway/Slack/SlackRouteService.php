<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 10.10.2018
 * Time: 15:58
 */

namespace App\Services\Common\Gateway\Slack;


use Illuminate\Notifications\Notifiable;

class SlackRouteService
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        return 'https://hooks.slack.com/services/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';
    }
}