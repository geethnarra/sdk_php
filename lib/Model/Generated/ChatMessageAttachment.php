<?php
namespace bunq\Model\Generated;

use bunq\Context\ApiContext;
use bunq\Http\ApiClient;
use bunq\Model\BunqModel;

/**
 * Create new messages holding file attachments.
 *
 * @generated
 */
class ChatMessageAttachment extends BunqModel
{
    /**
     * Field constants.
     */
    const FIELD_CLIENT_MESSAGE_UUID = 'client_message_uuid';
    const FIELD_ATTACHMENT = 'attachment';

    /**
     * Endpoint constants.
     */
    const ENDPOINT_URL_CREATE = 'user/%s/chat-conversation/%s/message-attachment';

    /**
     * Object type.
     */
    const OBJECT_TYPE = 'Id';

    /**
     * The id of the newly created chat message.
     *
     * @var int
     */
    protected $id;

    /**
     * Create a new message holding a file attachment to a specific
     * conversation.
     *
     * @param ApiContext $apiContext
     * @param mixed[] $requestMap
     * @param int $userId
     * @param int $chatConversationId
     * @param string[] $customHeaders
     *
     * @return int
     */
    public static function create(ApiContext $apiContext, array $requestMap, $userId, $chatConversationId, array $customHeaders = [])
    {
        $apiClient = new ApiClient($apiContext);
        $response = $apiClient->post(
            vsprintf(
                self::ENDPOINT_URL_CREATE,
                [$userId, $chatConversationId]
            ),
            $requestMap,
            $customHeaders
        );

        return static::processForId($response);
    }

    /**
     * The id of the newly created chat message.
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
