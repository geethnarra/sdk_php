<?php
namespace bunq\sdk\examples;

use bunq\Context\ApiContext;
use bunq\Model\Generated\CustomerStatementExport;
use bunq\Model\Generated\MonetaryAccount;
use bunq\Model\Generated\User;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Format of the customer statement.
 */
const CUSTOMER_STATEMENT_FORMAT = 'PDF';

/**
 * Format of the date required for customer statement.
 */
const FORMAT_DATE = 'Y-m-d';

/**
 * Very first index in an array.
 */
const INDEX_FIRST = 0;

/**
 * Constant to translate weeks to seconds.
 */
const SECONDS_IN_WEEK = 604800;

// Restore the API context.
$apiContext = ApiContext::restore();

// Retrieve the active user.
$userId = User::listing($apiContext)[INDEX_FIRST]->getUserCompany()->getId();

// Retrieve the first monetary account of the active user.
$monetaryAccountId = MonetaryAccount::listing($apiContext, $userId)[INDEX_FIRST]->getMonetaryAccountBank()->getId();

$dateStart = date(FORMAT_DATE, time() - SECONDS_IN_WEEK);
$dateEnd = date(FORMAT_DATE);

// Create a customer statement map.
$customerStatementMap = [
    CustomerStatementExport::FIELD_STATEMENT_FORMAT => CUSTOMER_STATEMENT_FORMAT,
    CustomerStatementExport::FIELD_DATE_START => $dateStart,
    CustomerStatementExport::FIELD_DATE_END => $dateEnd,
];

// Create a new customer statement and retrieve it's id.
$customerStatementId = CustomerStatementExport::create($apiContext, $customerStatementMap, $userId, $monetaryAccountId);

// Delete the customer statement.
CustomerStatementExport::delete($apiContext, $userId, $monetaryAccountId, $customerStatementId);

$apiContext->save();
