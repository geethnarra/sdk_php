<?php
namespace bunq\sdk\examples;

use bunq\Context\ApiContext;
use bunq\Model\Generated\MonetaryAccount;
use bunq\Model\Generated\Object\Amount;
use bunq\Model\Generated\Object\Pointer;
use bunq\Model\Generated\Payment;
use bunq\Model\Generated\User;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Update these constants to edit the values of the payment sent.
 */
const PAYMENT_AMOUNT = "12.30";
const PAYMENT_COUNTERPARTY_EMAIL = "isaias.beckwith@bunq.org";
const PAYMENT_DESCRIPTION = "This is a generated payment!";

/**
 * Other constants.
 */
const FILENAME_BUNQ_CONFIG = 'bunq.conf';
const CURRENCY_EUR = "EUR";
const POINTER_TYPE_EMAIL = "EMAIL";
const MESSAGE_MONETARY_ACCOUNT_NAME = 'Display name of monetary account: "%s"';

/**
 * Very first index in an array.
 */
const INDEX_FIRST = 0;

// Restore the API context.
$apiContext = ApiContext::restore(FILENAME_BUNQ_CONFIG);

// Retrieve the active user.
$userId = User::listing($apiContext)[INDEX_FIRST]->getUserCompany()->getId();

// Retrieve the first monetary account of the active user.
$monetaryAccountId = MonetaryAccount::listing($apiContext, $userId)[INDEX_FIRST]->getMonetaryAccountBank()->getId();

// Create a payment map.
$paymentMap = [
    Payment::FIELD_AMOUNT => new Amount(PAYMENT_AMOUNT, CURRENCY_EUR),
    Payment::FIELD_COUNTERPARTY_ALIAS => new Pointer(POINTER_TYPE_EMAIL, PAYMENT_COUNTERPARTY_EMAIL),
    Payment::FIELD_DESCRIPTION => PAYMENT_DESCRIPTION,
];

// Create a new payment and retrieve it's id.
$paymentId = Payment::create($apiContext, $paymentMap, $userId, $monetaryAccountId);

// Retrieve the payment.
$payment = Payment::get($apiContext, $userId, $monetaryAccountId, $paymentId);

vprintf(MESSAGE_MONETARY_ACCOUNT_NAME, [$payment->getAlias()->getDisplayName()]);
