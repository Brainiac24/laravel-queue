<?php

namespace App\Services\Common\Gateway\AbsTransport\Cards;

use App\Services\Common\Gateway\AbsTransport\AbsTransportEntity;
use App\Services\Common\Gateway\AbsTransport\TagEntity;

class CardEntity extends AbsTransportEntity
{

    const EO_R_CARDS_ITEM_SEARCH       = 'EO_R_CARDS_ITEM_SEARCH';
    const EO_R_CARDS_LIST              = 'EO_R_CARDS_LIST';
    const EO_R_CARDS_LIST_TRANSACTIONS = 'EO_R_CARDS_LIST_TRANSACTIONS';
    const EO_R_CARDS_ITEM_TRANSACTIONS = 'EO_R_CARDS_ITEM_TRANSACTIONS';
    const R_CR_SBERACC_CL_PRIV         = 'R_CR_SBERACC_CL_PRIV';
    const R_CR_PS_CARD                 = 'R_CR_PS_CARD';
    const R_GET_INFO_PS_CARD           = 'R_GET_INFO_PS_CARD';

    private $cards;
    private $card;
    private $pan;
    private $account;
    private $exp_date;
    private $cvv2;
    private $balance;
    private $curr_code;
    private $status;
    private $card_type;
    private $percentage;
    private $bank_name;
    private $bank_bic;
    private $bank_corr_acc;

    private $user_create_id;
    private $client_id;
    private $date_begin;
    private $card_type_id;
    private $emb_family;
    private $emb_name;
    private $secret_word;
    private $card_product_id;
    private $delivery_branch_id;
    private $tariff_id;
    private $depn;
    private $depn_id;
    private $vid_dog_id;
    private $fintool_id;
    private $card_pan;
    private $card_id;

    private $client_abs_id;
    private $create_user;
    private $kind;
    private $fintool;
    private $sum_dog;

    public function __construct()
    {
        $this->cards         = TagEntity::new('cards');
        $this->card          = TagEntity::new('card');
        $this->pan           = TagEntity::new('pan');
        $this->account       = TagEntity::new('account');
        $this->exp_date      = TagEntity::new('exp_date');
        $this->cvv2          = TagEntity::new('cvv2');
        $this->balance       = TagEntity::new('balance');
        $this->curr_code     = TagEntity::new('curr_code');
        $this->status        = TagEntity::new('status');
        $this->card_type     = TagEntity::new('type');
        $this->percentage    = TagEntity::new('percentage');
        $this->bank_name     = TagEntity::new('bank_name');
        $this->bank_bic      = TagEntity::new('bank_bic');
        $this->bank_corr_acc = TagEntity::new('bank_corr_ac');

        $this->user_create_id     = TagEntity::new('user_create_id');
        $this->client_id          = TagEntity::new('client_id');
        $this->date_begin         = TagEntity::new('date_begin');
        $this->card_type_id       = TagEntity::new('card_type_id');
        $this->emb_family         = TagEntity::new('emb_family');
        $this->emb_name           = TagEntity::new('emb_name');
        $this->secret_word        = TagEntity::new('secret_word');
        $this->card_product_id    = TagEntity::new('card_product_id');
        $this->delivery_branch_id = TagEntity::new('delivery_brach_id');
        $this->tariff_id          = TagEntity::new('tariff_id');
        $this->depn               = TagEntity::new('depn');
        $this->depn_id            = TagEntity::new('depn_id');
        $this->vid_dog_id         = TagEntity::new('vid_dog_id');
        $this->fintool_id         = TagEntity::new('fintool_id');
        $this->card_pan           = TagEntity::new('card_pan');
        $this->card_id            = TagEntity::new('card_id');

        $this->client_abs_id = TagEntity::new('client_abs_id');
        $this->create_user   = TagEntity::new('create_user');
        $this->kind          = TagEntity::new('kind');
        $this->fintool       = TagEntity::new('fintool');
        $this->sum_dog       = TagEntity::new('sum_dog');
    }

    public function getCards($cards = null)
    {
        is_null($cards) ?: $this->cards->setValue($cards);
        return $this->cards;
    }

    public function setCards($cards)
    {/**/
        $this->cards->setValue($cards);
    }

    public function getCard($card = null)
    {
        is_null($card) ?: $this->card->setValue($card);
        return $this->card;
    }

    public function setCard($card)
    {
        $this->card->setValue($card);
    }

    public function getPan($pan = null)
    {
        is_null($pan) ?: $this->pan->setValue($pan);
        return $this->pan;
    }

    public function setPan($pan)
    {
        $this->pan->setValue($pan);
    }

    public function getAccount($account = null)
    {
        is_null($account) ?: $this->account->setValue($account);
        return $this->account;
    }

    public function setAccount($account)
    {
        $this->account->setValue($account);
    }

    public function getExpDate($exp_date = null)
    {
        is_null($exp_date) ?: $this->exp_date->setValue($exp_date);
        return $this->exp_date;
    }

    public function setExpDate($exp_date)
    {
        $this->exp_date->setValue($exp_date);
    }

    public function getCvv2($cvv2 = null)
    {
        is_null($cvv2) ?: $this->cvv2->setValue($cvv2);
        return $this->cvv2;
    }

    public function setCvv2($cvv2)
    {
        $this->cvv2->setValue($cvv2);
    }

    public function getBalance($balance = null)
    {
        is_null($balance) ?: $this->balance->setValue($balance);
        return $this->balance;
    }

    public function setBalance($balance)
    {
        $this->balance->setValue($balance);
    }

    public function getCurrCode($curr_code = null)
    {
        is_null($curr_code) ?: $this->curr_code->setValue($curr_code);
        return $this->curr_code;
    }

    public function setCurrCode($curr_code)
    {
        $this->curr_code->setValue($curr_code);
    }

    public function getStatus($status = null)
    {
        is_null($status) ?: $this->status->setValue($status);
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status->setValue($status);
    }

    public function getCardType($card_type = null)
    {
        is_null($card_type) ?: $this->card_type->setValue($card_type);
        return $this->card_type;
    }

    public function setCardType($card_type)
    {
        $this->card_type->setValue($card_type);
    }

    public function getPercentage($percentage = null)
    {
        is_null($percentage) ?: $this->percentage->setValue($percentage);
        return $this->percentage;
    }

    public function setPercentage($percentage)
    {
        $this->percentage->setValue($percentage);
    }

    public function getBankName($bank_name = null)
    {
        is_null($bank_name) ?: $this->bank_name->setValue($bank_name);
        return $this->bank_name;
    }

    public function setBankName($bank_name)
    {
        $this->bank_name->setValue($bank_name);
    }

    public function getBankBic($bank_bic = null)
    {
        is_null($bank_bic) ?: $this->bank_bic->setValue($bank_bic);
        return $this->bank_bic;
    }

    public function setBankBic($bank_bic)
    {
        $this->bank_bic->setValue($bank_bic);
    }

    public function getBankCorrAcc($bank_corr_acc = null)
    {
        is_null($bank_corr_acc) ?: $this->bank_corr_acc->setValue($bank_corr_acc);
        return $this->bank_corr_acc;
    }

    public function setBankCorrAcc($bank_corr_acc)
    {
        $this->bank_corr_acc->setValue($bank_corr_acc);
    }

    public function getUserCreateId($user_create_id = null)
    {
        is_null($user_create_id) ?: $this->user_create_id->setValue($user_create_id);
        return $this->user_create_id;
    }

    public function setUserCreateId($user_create_id)
    {
        $this->user_create_id = $user_create_id;
    }

    public function getClientId($client_id = null)
    {
        is_null($client_id) ?: $this->client_id->setValue($client_id);
        return $this->client_id;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getDateBegin($date_begin = null)
    {
        is_null($date_begin) ?: $this->date_begin->setValue($date_begin);
        return $this->date_begin;
    }

    public function setDateBegin($date_begin)
    {
        $this->date_begin = $date_begin;
    }

    public function getCardTypeId($card_type_id = null)
    {
        is_null($card_type_id) ?: $this->card_type_id->setValue($card_type_id);
        return $this->card_type_id;
    }

    public function setCardTypeId($card_type_id)
    {
        $this->card_type_id = $card_type_id;
    }

    public function getEmbFamily($emb_family = null)
    {
        is_null($emb_family) ?: $this->emb_family->setValue($emb_family);
        return $this->emb_family;
    }

    public function setEmbFamily($emb_family)
    {
        $this->emb_family = $emb_family;
    }

    public function getEmbName($emb_name = null)
    {
        is_null($emb_name) ?: $this->emb_name->setValue($emb_name);
        return $this->emb_name;
    }

    public function setEmbName($emb_name)
    {
        $this->emb_name = $emb_name;
    }

    public function getSecretWord($secret_word = null)
    {
        is_null($secret_word) ?: $this->secret_word->setValue($secret_word);
        return $this->secret_word;
    }

    public function setSecretWord($secret_word)
    {
        $this->secret_word = $secret_word;
    }

    public function getCardProductId($card_product_id = null)
    {
        is_null($card_product_id) ?: $this->card_product_id->setValue($card_product_id);
        return $this->card_product_id;
    }

    public function setCardProductId($card_product_id)
    {
        $this->card_product_id = $card_product_id;
    }

    public function getDeliveryBranchId($delivery_branch_id = null)
    {
        is_null($delivery_branch_id) ?: $this->delivery_branch_id->setValue($delivery_branch_id);
        return $this->delivery_branch_id;
    }

    public function setDeliveryBranchId($delivery_branch_id)
    {
        $this->delivery_branch_id = $delivery_branch_id;
    }

    public function getTariffId($tariff_id = null)
    {
        is_null($tariff_id) ?: $this->tariff_id->setValue($tariff_id);
        return $this->tariff_id;
    }

    public function setTariffId($tariff_id)
    {
        $this->tariff_id = $tariff_id;
    }

    public function getDepn($depn = null)
    {
        is_null($depn) ?: $this->depn->setValue($depn);
        return $this->depn;
    }

    public function setDepn($depn)
    {
        $this->depn = $depn;
    }

    public function getDepnId($depn_id = null)
    {
        is_null($depn_id) ?: $this->depn_id->setValue($depn_id);
        return $this->depn_id;
    }

    public function setDepnId($depn_id)
    {
        $this->depn_id = $depn_id;
    }

    public function getVidDogId($vid_dog_id = null)
    {
        is_null($vid_dog_id) ?: $this->vid_dog_id->setValue($vid_dog_id);
        return $this->vid_dog_id;
    }

    public function setVidDogId($vid_dog_id)
    {
        $this->vid_dog_id = $vid_dog_id;
    }

    public function getFintoolId($fintool_id = null)
    {
        is_null($fintool_id) ?: $this->fintool_id->setValue($fintool_id);
        return $this->fintool_id;
    }

    public function setFintoolId($fintool_id)
    {
        $this->fintool_id = $fintool_id;
    }

    public function getCardPan($card_pan = null)
    {
        is_null($card_pan) ?: $this->card_pan->setValue($card_pan);
        return $this->card_pan;
    }

    public function setCardPan($card_pan)
    {
        $this->card_pan = $card_pan;
    }

    public function getClientAbsId($client_abs_id = null)
    {
        is_null($client_abs_id) ?: $this->client_abs_id->setValue($client_abs_id);
        return $this->client_abs_id;
    }

    public function setClientAbsId($client_abs_id)
    {
        $this->client_abs_id = $client_abs_id;
    }

    public function getKind($kind = null)
    {
        is_null($kind) ?: $this->kind->setValue($kind);
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getFintool($fintool = null)
    {
        is_null($fintool) ?: $this->fintool->setValue($fintool);
        return $this->fintool;
    }

    public function setFintool($fintool)
    {
        $this->fintool = $fintool;
    }

    public function getSumDog($sum_dog = null)
    {
        is_null($sum_dog) ?: $this->sum_dog->setValue($sum_dog);
        return $this->sum_dog;
    }

    public function setSumDog($sum_dog)
    {
        $this->sum_dog = $sum_dog;
    }

    public function getCardId($card_id = null)
    {
        is_null($card_id) ?: $this->card_id->setValue($card_id);
        return $this->card_id;
    }

    public function setCardId($card_id)
    {
        $this->card_id = $card_id;
    }


    public function getCreateUser($create_user = null)
    {
        is_null($create_user) ?: $this->create_user->setValue($create_user);
        return $this->create_user;
    }

    public function setCreateUser($create_user)
    {
        $this->create_user = $create_user;
    }
}
