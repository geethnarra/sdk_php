<?php
namespace bunq\Model\Generated;

use bunq\Context\ApiContext;
use bunq\Http\ApiClient;
use bunq\Model\BunqModel;
use bunq\Model\Generated\Object\Certificate;

/**
 * This endpoint allow you to pin the certificate chains to your account.
 * These certificate chains are used for SSL validation whenever a callback
 * is initiated to one of your https callback urls.
 *
 * @generated
 */
class CertificatePinned extends BunqModel
{
    /**
     * Field constants.
     */
    const FIELD_CERTIFICATE_CHAIN = 'certificate_chain';

    /**
     * Endpoint constants.
     */
    const ENDPOINT_URL_CREATE = 'user/%s/certificate-pinned';
    const ENDPOINT_URL_DELETE = 'user/%s/certificate-pinned/%s';
    const ENDPOINT_URL_LISTING = 'user/%s/certificate-pinned';
    const ENDPOINT_URL_READ = 'user/%s/certificate-pinned/%s';

    /**
     * Object type.
     */
    const OBJECT_TYPE = 'CertificatePinned';

    /**
     * The certificate chain in .PEM format.
     *
     * @var Certificate[]
     */
    protected $certificateChain;

    /**
     * The id generated for the pinned certificate chain.
     *
     * @var int
     */
    protected $id;

    /**
     * Pin the certificate chain.
     *
     * @param ApiContext $apiContext
     * @param mixed[] $requestMap
     * @param int $userId
     * @param string[] $customHeaders
     *
     * @return int
     */
    public static function create(ApiContext $apiContext, array $requestMap, $userId, array $customHeaders = [])
    {
        $apiClient = new ApiClient($apiContext);
        $response = $apiClient->post(
            vsprintf(
                self::ENDPOINT_URL_CREATE,
                [$userId]
            ),
            $requestMap,
            $customHeaders
        );

        return static::processForId($response);
    }

    /**
     * Remove the pinned certificate chain with the specific ID.
     *
     * @param ApiContext $apiContext
     * @param string[] $customHeaders
     * @param int $userId
     * @param int $certificatePinnedId
     */
    public static function delete(ApiContext $apiContext, $userId, $certificatePinnedId, array $customHeaders = [])
    {
        $apiClient = new ApiClient($apiContext);
        $apiClient->delete(
            vsprintf(
                self::ENDPOINT_URL_DELETE,
                [$userId, $certificatePinnedId]
            ),
            $customHeaders
        );
    }

    /**
     * List all the pinned certificate chain for the given user.
     *
     * This method is called "listing" because "list" is a restricted PHP word
     * and cannot be used as constants, class names, function or method names.
     *
     * @param ApiContext $apiContext
     * @param int $userId
     * @param string[] $customHeaders
     *
     * @return BunqModel[]|CertificatePinned[]
     */
    public static function listing(ApiContext $apiContext, $userId, array $customHeaders = [])
    {
        $apiClient = new ApiClient($apiContext);
        $response = $apiClient->get(
            vsprintf(
                self::ENDPOINT_URL_LISTING,
                [$userId]
            ),
            $customHeaders
        );

        return static::fromJsonList($response, self::OBJECT_TYPE);
    }

    /**
     * Get the pinned certificate chain with the specified ID.
     *
     * @param ApiContext $apiContext
     * @param int $userId
     * @param int $certificatePinnedId
     * @param string[] $customHeaders
     *
     * @return BunqModel|CertificatePinned
     */
    public static function get(ApiContext $apiContext, $userId, $certificatePinnedId, array $customHeaders = [])
    {
        $apiClient = new ApiClient($apiContext);
        $response = $apiClient->get(
            vsprintf(
                self::ENDPOINT_URL_READ,
                [$userId, $certificatePinnedId]
            ),
            $customHeaders
        );

        return static::fromJson($response);
    }

    /**
     * The certificate chain in .PEM format.
     *
     * @return Certificate[]
     */
    public function getCertificateChain()
    {
        return $this->certificateChain;
    }

    /**
     * @param Certificate[] $certificateChain
     */
    public function setCertificateChain(array$certificateChain)
    {
        $this->certificateChain = $certificateChain;
    }

    /**
     * The id generated for the pinned certificate chain.
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
