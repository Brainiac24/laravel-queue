<?php
/**
 * Created by PhpStorm.
 * User: Farrukh Kosimov
 * Date: 06.07.2018
 * Time: 15:56
 */

use App\Jobs\Processing\TransactionStatusDetail;

return [
    'server_url' => env('PROCESSING_URL', 'http://10.10.2.110:8443'),
    'point_id' => env('PROCESSING_POINT_ID', '500002'),
    'login' => env('PROCESSING_LOGIN', '500002'),
    'password' => env('PROCESSING_PASSWORD', 'D137CC92ZSVPHfFgZG'),
    'server_method' => 'GET',
    'authentication_method' => 'Basic',
    'command' => [
        'payment' => 'pay',
        'check_state' => 'check',
    ],
    'answers' => [
        '0' => ['message' => 'Запрос прошел успешно', 'fatal' => false, 'private_state_id' => TransactionStatusDetail::OK],
        '1' => ['message' => 'Временная ошибка. Повторите запрос позже', 'fatal' => false, 'private_state_id' => TransactionStatusDetail::ERROR_REQUEST],
        '4' => ['message' => 'Неверный формат идентификатора абонента', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_ACCOUNT_FORMAT],
        '5' => ['message' => 'Идентификатор абонента не найден (Ошиблись номером)', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_ACCOUNT_NOT_EXIST],
        '6' => ['message' => 'Заглушка ответа. По протоколу данный пункт не прописан.', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_UNKNOWN],
        '7' => ['message' => 'Прием платежа запрещен провайдером', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN],
        '8' => ['message' => 'Прием платежа запрещен по техническим причинам', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_ACCEPTED_IS_FORBIDDEN],
        '79' => ['message' => 'Счет абонента не активен', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_ACCOUNT_IS_NOT_ACTIVE],
        '90' => ['message' => 'Платеж находится в обработке', 'fatal' => false, 'private_state_id' => TransactionStatusDetail::IN_PROCESSING],
        '202' => ['message' => 'Ошибка данных запроса', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_REQUEST],
        '241' => ['message' => 'Сумма слишком мала', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_AMOUNT_IS_LESS],
        '242' => ['message' => 'Сумма слишком велика', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_AMOUNT_IS_GREATER],
        '243' => ['message' => 'Невозможно проверить состояние счета', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_REQUEST],
        '300' => ['message' => 'Другая ошибка провайдера', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_UNKNOWN],
        '3002' => ['message' => 'Превышена максимальная сумма', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_AMOUNT_IS_GREATER],
        '3003' => ['message' => 'Превышен дневной лимит', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_DAILY_LIMIT_EXCEEDED],
        '3004' => ['message' => 'Превышен недельный лимит', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_WEEKLY_LIMIT_EXCEEDED],
        '3005' => ['message' => 'Превышен месячный лимит', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_MONTHLY_LIMIT_EXCEEDED],
        '3007' => ['message' => 'Превышен максимально допустимый баланс кошелька', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_WALLET_LIMIT_EXCEEDED],
        '3012' => ['message' => 'Пополнение баланса ЭК временно заблокировано', 'fatal' => false, 'private_state_id' => TransactionStatusDetail::ERROR_REQUEST],
        '9998' => ['message' => 'Сетевая ошибка', 'fatal' => true, 'private_state_id' => TransactionStatusDetail::ERROR_PS],
        '9999' => ['message' => 'Сетевая ошибка', 'fatal' => false, 'private_state_id' => TransactionStatusDetail::ERROR_REQUEST],
    ],
];