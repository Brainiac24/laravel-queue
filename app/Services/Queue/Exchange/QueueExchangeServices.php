<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 30.08.2018
 * Time: 13:00
 */

namespace App\Services\Queue\Exchange;

use App\Jobs\AbsTransport\Accounts\DepositChangeContractAccountJob;
use Carbon\Carbon;
use Faker\Guesser\Name;
use App\Jobs\CallbackJob;
use App\Jobs\CallMeBackJob;
use App\Jobs\UserAccountsListJob;
use Illuminate\Support\Facades\App;
use App\Jobs\Processing\ProcessingJob;
use App\Jobs\RucardTransport\CancelJob;
use App\Jobs\RucardTransport\RefundJob;
use App\Jobs\TransferFromRu\PaymentJob;
use App\Jobs\Processing\ProcessingJobV2;
use App\Jobs\RucardTransport\ConfirmJob;
use App\Jobs\RucardTransport\FillCardJob;
use Illuminate\Support\Facades\Validator;
use App\Jobs\RucardTransport\Card2CardJob;
use App\Jobs\RucardTransport\LockUnlockJob;
use App\Jobs\AbsTransport\Cards\CardListJob;
use App\Jobs\RucardTransport\PayFromCardJob;
use App\Jobs\AbsTransport\Cards\CardOrderJob;
use App\Jobs\Processing\ProcessingGetInfoJob;
use App\Jobs\RucardTransport\CheckBalanceJob;
use App\Jobs\TransferFromRu\GetClientInfoJob;
use App\Jobs\AbsTransport\Cards\CardSearchJob;
use App\Jobs\RucardTransport\CheckFillCardJob;
use App\Jobs\TransCapitalBankJobs\BindCardJob;
use App\Services\Queue\Hash\QueueHashContract;
use App\Jobs\BpcMtmTransport\BpcMtmFillCardJob;
use App\Jobs\BpcMtmTransport\BpcMtmReversalJob;
use App\Jobs\RucardTransport\CheckCard2CardJob;
use App\Jobs\AbsCurrencyRate\AbsCurrencyRateJob;
use App\Jobs\AbsTransport\Accounts\AccountContractJob;
use App\Jobs\AbsTransport\Credits\CreditListJob;
use App\Jobs\AbsTransport\Users\CreateClientJob;
use App\Jobs\AbsTransport\Users\SearchClientJob;
use App\Jobs\AbsTransport\Users\UpdateClientJob;
use App\Jobs\BpcMtmTransport\BpcMtmCard2CardJob;
use App\Jobs\SendTransactionDataToWebHookUrlJob;
use App\Jobs\SmsNotification\SmsNotificationJob;
use App\Services\Queue\Exchange\Enums\QueueEnum;
use App\Jobs\RucardTransport\CheckPayFromCardJob;
use App\Jobs\AbsTransport\Accounts\AccountListJob;
use App\Jobs\AbsTransport\Accounts\DepositListJob;
use App\Jobs\BpcMtmTransport\BpcMtmGetCardDataJob;
use App\Jobs\BpcMtmTransport\BpcMtmPayFromCardJob;
use App\Jobs\PushNotification\PushNotificationJob;
use App\Services\Queue\Exchange\Enums\GatewayEnum;
use App\Services\Queue\Exchange\Enums\HandlerEnum;
use App\Jobs\AbsTransport\Accounts\DepositCloseJob;
use App\Jobs\AbsTransport\Cards\CardCheckStatusJob;
use App\Jobs\TransCapitalBankJobs\GetOrderStateJob;
use App\Jobs\AbsTransport\Accounts\AccountCreateJob;
use App\Jobs\AbsTransport\Accounts\DepositCreateJob;
use App\Jobs\AbsTransport\Cards\CardTransactionsJob;
use App\Jobs\EmailNotification\EmailNotificationJob;
use App\Jobs\AbsTransport\Cards\CardOrderCallbackJob;
use App\Jobs\BpcMtmTransport\BpcMtmLockUnlockCardJob;
use App\Jobs\TransCapitalBankJobs\GetPaymentStateJob;
use App\Jobs\BpcMtmTransport\BpcMtmGetTransactionsJob;
use App\Jobs\TransCapitalBankJobs\GetBindCardStateJob;
use App\Jobs\AbsTransport\Accounts\AccountToAccountJob;
use App\Jobs\AbsTransport\TransfersLid\TransfersLidJob;
use App\Jobs\AbsTransport\Users\RegisterClientInAbsJob;
use App\Jobs\AbsTransport\Accounts\LiquidateExchangeJob;
use App\Jobs\TransCapitalBankJobs\FillRegisteredCardJob;
use App\Jobs\AbsTransport\Accounts\AccountToAccountV2Job;
use App\Jobs\AbsTransport\Accounts\AccountToAccountSyncJob;
use App\Jobs\AbsTransport\Accounts\AccountToPayCreditV2Job;
use App\Jobs\AbsTransport\Accounts\LiquidateTransactionJob;
use App\Jobs\TransCapitalBankJobs\PayFromRegisteredCardJob;
use App\Jobs\AbsTransport\Accounts\AccountToPayOverdraftJob;
use App\Jobs\AbsTransport\Credits\CreditTransactionsFactJob;
use App\Jobs\AbsTransport\Credits\CreditTransactionsPlanJob;
use App\Jobs\AbsTransport\Accounts\AccountToAccountSyncV2Job;
use App\Jobs\AbsTransport\Accounts\AccountTransactionListJob;
use App\Jobs\AbsTransport\Accounts\DepositTransactionListJob;
use App\Jobs\AbsTransport\Accounts\LiquidateTransactionV2Job;
use App\Jobs\AbsTransport\TransfersSoniya\TransfersSoniyaJob;
use App\Jobs\AbsTransport\Cards\CardCreateInsuranceAccountJob;
use App\Jobs\AbsTransport\Accounts\AccountToAccountExchangeJob;
use App\Jobs\AbsTransport\Accounts\DepositCodecJob;
use App\Jobs\AbsTransport\Accounts\DepositContractJob;
use App\Jobs\AbsTransport\TransfersSoniya\TransfersSoniyaV2Job;
use App\Services\Queue\Exchange\Exceptions\ValidationException;
use App\Services\Queue\Exchange\Exceptions\InvalidHashException;
use App\Jobs\AbsTransport\TransfersSoniya\ConfirmTransfersSoniyaJob;
use App\Services\Queue\Exchange\Exceptions\HandlerNotFoundException;
use App\Jobs\AbsTransport\TransfersSoniya\CheckTransferSoniyaStatusJob;
use App\Jobs\AbsTransport\Users\GetClientDataJob;
use App\Jobs\BpcVisaTransport\BpcVisaFillCardJob as BPC_VISA_FillCardJob;
use App\Jobs\BpcVisaTransport\BpcVisaReversalJob as BPC_VISA_ReversalJob;
use App\Services\Queue\Exchange\Exceptions\ClassHandlerNotFoundException;
use App\Jobs\BpcVisaTransport\BpcVisaCard2CardJob as BPC_VISA_Card2CardJob;
use App\Jobs\BpcVisaTransport\BpcVisaGetCardDataJob as BPC_VISA_GetCardDataJob;
use App\Jobs\BpcVisaTransport\BpcVisaPayFromCardJob as BPC_VISA_PayFromCardJob;
use App\Services\Queue\Exchange\Exceptions\MethodDispatchInClassNotFoundException;
use App\Jobs\BpcVisaTransport\BpcVisaLockUnlockCardJob as BPC_VISA_LockUnlockCardJob;
use App\Jobs\BpcVisaTransport\BpcVisaGetTransactionsJob as BPC_VISA_GetTransactionsJob;

class QueueExchangeServices
{
    protected $secret_key;
    protected $hash;

    /**
     * QueueExchangeServices constructor.
     * @param $hash
     */
    public function __construct(QueueHashContract $hash)
    {
        $this->hash = $hash;
    }

    //public function pay($txn_id,$sum,$prv_id,$number);
    public function map()
    {
        return [
            HandlerEnum::PROCESSING => [
                GatewayEnum::DEFAULT=> [
                    'class' => ProcessingJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => ProcessingJob::rules(),
                ],
            ],
            HandlerEnum::PROCESSING_V2 => [
                GatewayEnum::DEFAULT=> [
                    'class' => ProcessingJobV2::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => ProcessingJobV2::rules(),
                ],
            ],
            HandlerEnum::PROCESSING_GET_INFO => [
                GatewayEnum::DEFAULT=> [
                    'class' => ProcessingGetInfoJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => ProcessingGetInfoJob::rules(),
                ],
            ],
            HandlerEnum::SMS_NOTIFICATION => [
                GatewayEnum::DEFAULT=> [
                    'class' => SmsNotificationJob::class,
                    'queue' => QueueEnum::NOTIFICATION,
                    'validation_rule' => SmsNotificationJob::rules(),
                ],
            ],
            HandlerEnum::EMAIL_NOTIFICATION => [
                GatewayEnum::DEFAULT=> [
                    'class' => EmailNotificationJob::class,
                    'queue' => QueueEnum::NOTIFICATION,
                    'validation_rule' => EmailNotificationJob::rules(),
                ],
            ],
            HandlerEnum::PUSH_NOTIFICATION => [
                GatewayEnum::DEFAULT=> [
                    'class' => PushNotificationJob::class,
                    'queue' => QueueEnum::NOTIFICATION,
                    'validation_rule' => PushNotificationJob::rules(),
                ],
            ],
            HandlerEnum::ABS_CURRENCY_RATE => [
                GatewayEnum::DEFAULT=> [
                    'class' => AbsCurrencyRateJob::class,
                    'queue' => QueueEnum::DEFAULT,
                    'validation_rule' => AbsCurrencyRateJob::rules(),
                ],
            ],
            HandlerEnum::ABS_CARDS_SEARCH => [
                GatewayEnum::DEFAULT=> [
                    'class' => CardSearchJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CardSearchJob::rules(),
                ],
            ],
            HandlerEnum::ABS_CARDS_LIST => [
                GatewayEnum::ABS=> [
                    'class' => CardListJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CardListJob::rules(),
                ],
            ],
            HandlerEnum::ABS_CARDS_ITEM_TRANSACTIONS => [
                GatewayEnum::DEFAULT=> [
                    'class' => CardTransactionsJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CardTransactionsJob::rules(),
                ],
            ],
            HandlerEnum::CANCEL => [
                GatewayEnum::RUCARD => [
                    'class' => CancelJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CancelJob::rules(),
                ],
            ],
            HandlerEnum::CONFIRM => [
                GatewayEnum::RUCARD => [
                    'class' => ConfirmJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => ConfirmJob::rules(),
                ],
            ],
            HandlerEnum::CARD_TRANSACTIONS_LIST => [
                GatewayEnum::ABS => [
                    'class' => CardTransactionsJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CardTransactionsJob::rules(),
                ],
                GatewayEnum::BPC_MTM => [
                    'class' => BpcMtmGetTransactionsJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => BpcMtmGetTransactionsJob::rules(),
                ],
                GatewayEnum::BPC_VISA => [
                    'class' => BPC_VISA_GetTransactionsJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BPC_VISA_GetTransactionsJob::rules(),
                ],
            ],
            HandlerEnum::FILL => [
                GatewayEnum::RUCARD => [
                    'class' => CheckFillCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CheckFillCardJob::rules(),
                ],
                GatewayEnum::BPC_MTM => [
                    'class' => BpcMtmFillCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BpcMtmFillCardJob::rules(),
                ],
                GatewayEnum::BPC_VISA => [
                    'class' => BPC_VISA_FillCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BPC_VISA_FillCardJob::rules(),
                ],
            ],
            HandlerEnum::CARD_LOCK_UNLOCK => [
                GatewayEnum::RUCARD => [
                    'class' => LockUnlockJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => LockUnlockJob::rules(),
                ],
                GatewayEnum::BPC_MTM => [
                    'class' => BpcMtmLockUnlockCardJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => BpcMtmLockUnlockCardJob::rules(),
                ],
                GatewayEnum::BPC_VISA => [
                    'class' => BPC_VISA_LockUnlockCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BPC_VISA_LockUnlockCardJob::rules(),
                ],
            ],
            HandlerEnum::BLOCK_AMOUNT => [
                GatewayEnum::RUCARD => [
                    'class' => CheckPayFromCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CheckPayFromCardJob::rules(),
                ],
                GatewayEnum::BPC_MTM => [
                    'class' => BpcMtmPayFromCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BpcMtmPayFromCardJob::rules(),
                ],
                GatewayEnum::BPC_VISA => [
                    'class' => BPC_VISA_PayFromCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BPC_VISA_PayFromCardJob::rules(),
                ],
            ],
            HandlerEnum::BALANCE => [
                GatewayEnum::RUCARD => [
                    'class' => CheckBalanceJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CheckBalanceJob::rules(),
                ],
                GatewayEnum::BPC_MTM => [
                    'class' => BpcMtmGetCardDataJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => BpcMtmGetCardDataJob::rules(),
                ],
                GatewayEnum::BPC_VISA => [
                    'class' => BPC_VISA_GetCardDataJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BPC_VISA_GetCardDataJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT => [
                GatewayEnum::RUCARD => [
                    'class' => CheckCard2CardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CheckCard2CardJob::rules(),
                ],
                GatewayEnum::ABS => [
                    'class' => AccountToAccountJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => AccountToAccountJob::rules(),
                ],
                GatewayEnum::BPC_MTM => [
                    'class' => BpcMtmCard2CardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BpcMtmCard2CardJob::rules(),
                ],
                GatewayEnum::BPC_VISA => [
                    'class' => BPC_VISA_Card2CardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BPC_VISA_Card2CardJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT_V2 => [
                GatewayEnum::RUCARD => [
                    'class' => CheckCard2CardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CheckCard2CardJob::rules(),
                ],
                GatewayEnum::ABS => [
                    'class' => AccountToAccountV2Job::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => AccountToAccountV2Job::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT_SYNC => [
                GatewayEnum::ABS => [
                    'class' => AccountToAccountSyncJob::class,
                    'queue' => QueueEnum::DEFAULT,
                    'validation_rule' => AccountToAccountSyncJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT_SYNC_V2 => [
                GatewayEnum::ABS => [
                    'class' => AccountToAccountSyncV2Job::class,
                    'queue' => QueueEnum::DEFAULT,
                    'validation_rule' => AccountToAccountSyncV2Job::rules(),
                ],
            ],
            HandlerEnum::ACCOUNTS_LIST => [
                GatewayEnum::ABS => [
                    'class' => AccountListJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => AccountListJob::rules(),
                ],
            ],
            HandlerEnum::DEPOSITS_LIST => [
                GatewayEnum::ABS => [
                    'class' => DepositListJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => DepositListJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNTS_ITEM_TRANSACTIONS => [
                GatewayEnum::ABS => [
                    'class' => AccountTransactionListJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => AccountTransactionListJob::rules(),
                ],
            ],
            HandlerEnum::DEPOSITS_ITEM_TRANSACTIONS => [
                GatewayEnum::ABS => [
                    'class' => DepositTransactionListJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => DepositTransactionListJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT_LIQUIDATE => [
                GatewayEnum::ABS => [
                    'class' => LiquidateTransactionJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => LiquidateTransactionJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT_LIQUIDATE_V2 => [
                GatewayEnum::ABS => [
                    'class' => LiquidateTransactionV2Job::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => LiquidateTransactionV2Job::rules(),
                ],
                GatewayEnum::BPC_MTM => [
                    'class' => BpcMtmReversalJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BpcMtmReversalJob::rules(),
                ],
                GatewayEnum::BPC_VISA => [
                    'class' => BPC_VISA_ReversalJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => BPC_VISA_ReversalJob::rules(),
                ],
            ],
            HandlerEnum::TRANSFERS_LID => [
                GatewayEnum::DEFAULT=> [
                    'class' => TransfersLidJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => TransfersLidJob::rules(),
                ],
            ],
            HandlerEnum::TRANSFERS_SONIYA => [
                GatewayEnum::DEFAULT=> [
                    'class' => TransfersSoniyaJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => TransfersSoniyaJob::rules(),
                ],
            ],
            HandlerEnum::TRANSFERS_SONIYA_CONFIRM => [
                GatewayEnum::DEFAULT=> [
                    'class' => ConfirmTransfersSoniyaJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => ConfirmTransfersSoniyaJob::rules(),
                ],
            ],
            HandlerEnum::TRANSFERS_SONIYA_V2 => [
                GatewayEnum::DEFAULT=> [
                    'class' => TransfersSoniyaV2Job::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => TransfersSoniyaV2Job::rules(),
                ],
            ],
            HandlerEnum::TRANSFERS_SONIYA_CHECK_STATUS => [
                GatewayEnum::DEFAULT=> [
                    'class' => CheckTransferSoniyaStatusJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CheckTransferSoniyaStatusJob::rules(),
                ],
            ],
            HandlerEnum::CALLBACK_GET_USER_ACCOUNTS_LIST => [
                GatewayEnum::DEFAULT=> [
                    'class' => UserAccountsListJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => UserAccountsListJob::rules(),
                ],
            ],
            HandlerEnum::CREDITS_LIST => [
                GatewayEnum::ABS => [
                    'class' => CreditListJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CreditListJob::rules(),
                ],
            ],
            HandlerEnum::CREDITS_ITEM_TRANSACTIONS_FACT => [
                GatewayEnum::ABS => [
                    'class' => CreditTransactionsFactJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CreditTransactionsFactJob::rules(),
                ],
            ],
            HandlerEnum::CREDITS_ITEM_TRANSACTIONS_PLAN => [
                GatewayEnum::ABS => [
                    'class' => CreditTransactionsPlanJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CreditTransactionsPlanJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT_EXCHANGE => [
                GatewayEnum::ABS => [
                    'class' => AccountToAccountExchangeJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => AccountToAccountExchangeJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_TO_ACCOUNT_EXCHANGE_LIQUIDATE => [
                GatewayEnum::ABS => [
                    'class' => LiquidateExchangeJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => LiquidateExchangeJob::rules(),
                ],
            ],
            HandlerEnum::CARD_INSURANCE_ACCOUNT_CREATE => [
                GatewayEnum::ABS => [
                    'class' => CardCreateInsuranceAccountJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CardCreateInsuranceAccountJob::rules(),
                ],
            ],
            HandlerEnum::CARD_ORDER_CREATE => [
                GatewayEnum::ABS => [
                    'class' => CardOrderJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CardOrderJob::rules(),
                ],
            ],
            HandlerEnum::CARD_ORDER_STATUS_CHECK => [
                GatewayEnum::ABS => [
                    'class' => CardCheckStatusJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CardCheckStatusJob::rules(),
                ],
            ],
            HandlerEnum::CALL_ME_BACK => [
                GatewayEnum::DEFAULT => [
                    'class' => CallMeBackJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => CallMeBackJob::rules(),
                ],
            ],
            HandlerEnum::BIND_FOREIGN_CARD => [
                GatewayEnum::TKB => [
                    'class' => BindCardJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => BindCardJob::rules(),
                ],
            ],
            HandlerEnum::GET_BIND_FOREIGN_CARD_STATE => [
                GatewayEnum::TKB => [
                    'class' => GetBindCardStateJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => GetBindCardStateJob::rules(),
                ],
            ],
            HandlerEnum::GET_FOREIGN_CARD_PAYMENT_STATE => [
                GatewayEnum::TKB => [
                    'class' => GetPaymentStateJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => GetPaymentStateJob::rules(),
                ],
            ],
            HandlerEnum::PAY_FROM_REGISTERED_CARD => [
                GatewayEnum::TKB => [
                    'class' => PayFromRegisteredCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => PayFromRegisteredCardJob::rules(),
                ],
            ],
            HandlerEnum::FILL_REGISTERED_CARD => [
                GatewayEnum::TKB => [
                    'class' => FillRegisteredCardJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => FillRegisteredCardJob::rules(),
                ],
            ],
            HandlerEnum::GET_CLIENT_INFO => [
                GatewayEnum::ABS => [
                    'class' => GetClientInfoJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => GetClientInfoJob::rules(),
                ],
            ],
            HandlerEnum::PAYMENT => [
                GatewayEnum::ABS => [
                    'class' => PaymentJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => PaymentJob::rules(),
                ],
            ],
            HandlerEnum::SEND_DATA_TO_WEBHOOK => [
                GatewayEnum::DEFAULT => [
                    'class' => SendTransactionDataToWebHookUrlJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => SendTransactionDataToWebHookUrlJob::rules(),
                ],
            ],
            HandlerEnum::SEARCH_CLIENT => [
                GatewayEnum::DEFAULT => [
                    'class' => SearchClientJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => SearchClientJob::rules(),
                ],
            ],
            HandlerEnum::CREATE_CLIENT => [
                GatewayEnum::DEFAULT => [
                    'class' => CreateClientJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => CreateClientJob::rules(),
                ],
            ],
            HandlerEnum::REGISTER_CLIENT => [
                GatewayEnum::DEFAULT => [
                    'class' => RegisterClientInAbsJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => RegisterClientInAbsJob::rules(),
                ],
            ],
            HandlerEnum::UPDATE_CLIENT => [
                GatewayEnum::DEFAULT => [
                    'class' => UpdateClientJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => UpdateClientJob::rules(),
                ],
            ],
            HandlerEnum::ABS_PAY_CREDIT_BY_ID_CONTRACT => [
                GatewayEnum::ABS => [
                    'class' => AccountToPayCreditV2Job::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => AccountToPayCreditV2Job::rules(),
                ],
            ],
            HandlerEnum::ABS_PAY_OVERDRAFT_BY_PAN_CARD => [
                GatewayEnum::ABS => [
                    'class' => AccountToPayOverdraftJob::class,
                    'queue' => QueueEnum::PROCESSING,
                    'validation_rule' => AccountToPayOverdraftJob::rules(),
                ],
            ],
            HandlerEnum::CREATE_DEPOSIT => [
                GatewayEnum::ABS => [
                    'class' => DepositCreateJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => DepositCreateJob::rules(),
                ],
            ],
            HandlerEnum::CLOSE_DEPOSIT => [
                GatewayEnum::ABS => [
                    'class' => DepositCloseJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => DepositCloseJob::rules(),
                ],
            ],
            HandlerEnum::CREATE_ACCOUNT => [
                GatewayEnum::ABS => [
                    'class' => AccountCreateJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => AccountCreateJob::rules(),
                ],
            ],
            HandlerEnum::DEPOSIT_CONTRACT => [
                GatewayEnum::ABS => [
                    'class' => DepositContractJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => DepositContractJob::rules(),
                ],
            ],
            HandlerEnum::ACCOUNT_CONTRACT => [
                GatewayEnum::ABS => [
                    'class' => AccountContractJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => AccountContractJob::rules(),
                ],
            ],
            HandlerEnum::GET_CLIENT_DATA => [
                GatewayEnum::ABS => [
                    'class' => GetClientDataJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => GetClientDataJob::rules(),
                ],
            ],
            HandlerEnum::CHANGE_DEPOSIT_ACCOUNT => [
                GatewayEnum::ABS => [
                    'class' => DepositChangeContractAccountJob::class,
                    'queue' => QueueEnum::REQUEST,
                    'validation_rule' => DepositChangeContractAccountJob::rules(),
                ],
            ],
        ];
    }

    /**
     * @param string $handler
     * @param array $payload
     * @param Carbon|null $availableAt
     * @param bool $withQueue
     * @param string $datetime
     * @param string $hash
     * @return bool
     * @throws ClassHandlerNotFoundException
     * @throws HandlerNotFoundException
     * @throws MethodDispatchInClassNotFoundException
     * @throws ValidationException
     * @throws \Exception
     */
    public function handle(string $handler, array $payload, Carbon $availableAt = null, bool $withQueue = true, string $datetime, string $hash)
    {

        $gateway = $payload['gateway'] ?? GatewayEnum::DEFAULT;
        $className = $this->map()[$handler][$gateway]['class'];
        $queueName = $this->map()[$handler][$gateway]['queue'];

        if (!isset($className)) {
            throw new HandlerNotFoundException("Class {$className} not found");
        }

        if (!class_exists($className)) {
            throw new ClassHandlerNotFoundException("Class {$className} handle not found");
        }

        if (!method_exists($className, 'dispatch')) {
            throw new MethodDispatchInClassNotFoundException("Method dispatch to handler {$className} not found");
        }

        $validator = Validator::make($payload, $this->map()[$handler][$gateway]['validation_rule']);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                throw new ValidationException($error);
            }
        }

        if (App::environment() == 'production1') {
            if (!$this->hash->check($hash, $datetime, $payload)) {
                throw new InvalidHashException('Invalid hash');
            }
        }

        if ($withQueue == true) {

            if ($availableAt != null) {
                $className::dispatch($payload)->delay($availableAt)->onQueue($queueName);
            } else {
                $className::dispatch($payload)->onQueue($queueName);
            }

        } else {
            return (new $className($payload))->handle();
        }

        return null;
    }

}
