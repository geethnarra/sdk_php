<?php
namespace bunq\Model\Generated;

use bunq\Context\ApiContext;
use bunq\Http\ApiClient;
use bunq\Model\BunqModel;

/**
 * When you have connected your monetary account bank to a user, and given
 * this user a (for example) daily budget of 10 EUR. If this users has used
 * his entire budget or part of it, this call can be used to reset the
 * amount he used to 0. The user can then spend the daily budget of 10 EUR
 * again.
 *
 * @generated
 */
class ShareInviteBankAmountUsed extends BunqModel
{
    /**
     * Endpoint constants.
     */
    const ENDPOINT_URL_DELETE = 'user/%s/monetary-account/%s/share-invite-bank-inquiry/%s/amount-used/%s';

    /**
     * Object type.
     */
    const OBJECT_TYPE = 'ShareInviteBankAmountUsed';

    /**
     * Reset the available budget for a bank account share. To be called without
     * any ID at the end of the path.
     *
     * @param ApiContext $apiContext
     * @param string[] $customHeaders
     * @param int $userId
     * @param int $monetaryAccountId
     * @param int $shareInviteBankInquiryId
     * @param int $shareInviteBankAmountUsedId
     */
    public static function delete(ApiContext $apiContext, $userId, $monetaryAccountId, $shareInviteBankInquiryId, $shareInviteBankAmountUsedId, array $customHeaders = [])
    {
        $apiClient = new ApiClient($apiContext);
        $apiClient->delete(
            vsprintf(
                self::ENDPOINT_URL_DELETE,
                [$userId, $monetaryAccountId, $shareInviteBankInquiryId, $shareInviteBankAmountUsedId]
            ),
            $customHeaders
        );
    }
}
