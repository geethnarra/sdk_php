<?php
namespace bunq\Model\Generated;

use bunq\Context\ApiContext;
use bunq\Http\ApiClient;
use bunq\Model\BunqModel;
use bunq\Model\Generated\Object\Attachment;

/**
 * This call is used to upload an attachment that can be referenced to in
 * payment requests and payments sent from a specific monetary account.
 * Attachments supported are png, jpg and gif.
 *
 * @generated
 */
class AttachmentMonetaryAccount extends BunqModel
{
    /**
     * Binary constants.
     */
    const FIELD_BODY = ApiClient::FIELD_BODY;
    const FIELD_CONTENT_TYPE = ApiClient::FIELD_CONTENT_TYPE;
    const FIELD_DESCRIPTION = ApiClient::FIELD_DESCRIPTION;

    /**
     * Endpoint constants.
     */
    const ENDPOINT_URL_CREATE = 'user/%s/monetary-account/%s/attachment';

    /**
     * Object type.
     */
    const OBJECT_TYPE = 'AttachmentMonetaryAccount';

    /**
     * The attachment.
     *
     * @var Attachment
     */
    protected $attachment;

    /**
     * The ID of the attachment created.
     *
     * @var int
     */
    protected $id;

    /**
     * Create a new monetary account attachment. Create a POST request with a
     * payload that contains the binary representation of the file, without any
     * JSON wrapping. Make sure you define the MIME type (i.e. image/jpeg) in
     * the Content-Type header. You are required to provide a description of the
     * attachment using the X-Bunq-Attachment-Description header.
     *
     * @param ApiContext $apiContext
     * @param string $requestBytes
     * @param int $userId
     * @param int $monetaryAccountId
     * @param string[] $customHeaders
     *
     * @return int
     */
    public static function create(ApiContext $apiContext, $requestBytes, $userId, $monetaryAccountId, array $customHeaders = [])
    {
        $apiClient = new ApiClient($apiContext);
        $apiClient->enableBinary();
        $response = $apiClient->post(
            vsprintf(
                self::ENDPOINT_URL_CREATE,
                [$userId, $monetaryAccountId]
            ),
            $requestBytes,
            $customHeaders
        );

        return static::processForId($response);
    }

    /**
     * The attachment.
     *
     * @return Attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param Attachment $attachment
     */
    public function setAttachment(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * The ID of the attachment created.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
