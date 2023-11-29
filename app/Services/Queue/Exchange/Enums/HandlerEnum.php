<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 30.08.2018
 * Time: 13:01
 */

namespace App\Services\Queue\Exchange\Enums;


class HandlerEnum
{
    const PROCESSING = 'processing';
    const PROCESSING_V2 = 'processing_v2';
    const PROCESSING_GET_INFO = 'processing_get_info';
    const SMS_NOTIFICATION = 'sms_notification';
    const EMAIL_NOTIFICATION = 'email_notification';
    const PUSH_NOTIFICATION = 'push_notification';
    const ABS_CURRENCY_RATE = 'abs_currency_rate';
    const ABS_CARDS_SEARCH = 'abs_cards_search';
    const ABS_CARDS_LIST = 'abs_cards_list';
    const ABS_CARDS_ITEM_TRANSACTIONS = 'abs_cards_item_transactions';
    
    const BLOCK_AMOUNT = 'block';
    const FILL = 'fill';
    const ACCOUNT_TO_ACCOUNT = 'account_to_account';
    const ACCOUNT_TO_ACCOUNT_V2 = 'account_to_account_v2';
    const ACCOUNT_TO_ACCOUNT_LIQUIDATE = 'account_to_account_liquidate';
    const ACCOUNT_TO_ACCOUNT_LIQUIDATE_V2 = 'account_to_account_liquidate_v2';
    const ACCOUNT_TO_ACCOUNT_EXCHANGE = 'account_to_account_exchange';
    const ACCOUNT_TO_ACCOUNT_EXCHANGE_LIQUIDATE = 'account_to_account_exchange_liquidate';
    const ACCOUNT_TO_ACCOUNT_SYNC = 'account_to_account_sync';
    const ACCOUNT_TO_ACCOUNT_SYNC_V2 = 'account_to_account_sync_v2';
    const CONFIRM = 'confirm';
    const CANCEL = 'cancel';
    const BALANCE = 'balance';
    const ACCOUNTS_LIST = 'accounts_list';
    const ACCOUNTS_ITEM_TRANSACTIONS = 'account_transactions_list';
    const DEPOSITS_LIST = 'deposits_list';
    const DEPOSITS_ITEM_TRANSACTIONS = 'deposit_transactions_list';
    //const ACCOUNTS_ITEM_TRANSACTIONS_ITEM_CREATE = 'accounts_item_transactions_item_create';
    const CREDITS_LIST = 'credits_list';
    const CREDITS_ITEM_TRANSACTIONS_FACT = 'credits_item_transactions_fact';
    const CREDITS_ITEM_TRANSACTIONS_PLAN = 'credits_item_transactions_plan';
    const CARD_INSURANCE_ACCOUNT_CREATE = 'card_insurance_account_create';
    const CARD_ORDER_CREATE = 'card_order_create';
    const CARD_ORDER_STATUS_CHECK = 'card_order_status_check';

    const CARD_LOCK_UNLOCK = 'card_lock_unlock';
    const CARD_TRANSACTIONS_LIST = 'card_transactions_list';
    const CARD_TRANSACTION_REFUND = 'card_transaction_refund';
    const TRANSFERS_LID = 'transfers_lid';
    const TRANSFERS_SONIYA = 'transfers_soniya';
    const TRANSFERS_SONIYA_V2 = 'transfers_soniya_v2';
    const TRANSFERS_SONIYA_CONFIRM = 'transfers_soniya_confirm';
    const TRANSFERS_SONIYA_CHECK_STATUS = 'transfers_soniya_check_status';
    const CALLBACK_GET_USER_ACCOUNTS_LIST = 'callback_get_user_accounts_list';
    const CALL_ME_BACK = 'call_me_back';

    const BIND_FOREIGN_CARD = 'bind_foreign_card';
    const GET_BIND_FOREIGN_CARD_STATE = 'get_bind_foreign_card_state';
    const GET_FOREIGN_CARD_PAYMENT_STATE = 'get_foreign_card_payment_state';
    const PAY_FROM_REGISTERED_CARD = 'pay_from_registered_card';//'register_order_from_registered_card';
    const FILL_REGISTERED_CARD = 'fill_registered_card';
    const GET_CLIENT_INFO = 'get_client_info';
    const PAYMENT = 'payment';
    const SEND_DATA_TO_WEBHOOK = 'send_data_to_webhook';

    const SEARCH_CLIENT = 'search_client';
    const CREATE_CLIENT = 'create_client';
    const REGISTER_CLIENT = 'register_client';
    const UPDATE_CLIENT = 'update_client';

    const ABS_PAY_CREDIT_BY_ID_CONTRACT = 'abs_pay_credit_by_id_contract';
    const ABS_PAY_OVERDRAFT_BY_PAN_CARD = 'abs_pay_overdraft_by_pan_card';

    const CREATE_DEPOSIT = 'create_deposit';
    const CLOSE_DEPOSIT = 'close_deposit';
    const CREATE_ACCOUNT = 'create_account';


    const ACCOUNT_CONTRACT = 'account_contract';
    const DEPOSIT_CONTRACT = 'deposit_contract';

    const GET_CLIENT_DATA = 'get_client_data';
    const CHANGE_DEPOSIT_ACCOUNT = 'change_deposit_account';

}