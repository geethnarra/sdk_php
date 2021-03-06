<?php
namespace bunq\Http\Handler;

use bunq\Exception\SecurityException;
use bunq\Security\PublicKey;
use Psr\Http\Message\ResponseInterface;

/**
 */
class ResponseHandlerSignature extends ResponseHandlerBase
{
    /**
     * Error constants.
     */
    const ERROR_VERIFYING_RESPONSE_FAILED = 'Verifying response failed.';

    /**
     * Header constants.
     */
    const HEADER_SERVER_SIGNATURE = 'X-Bunq-Server-Signature';
    const HEADER_PREFIX = 'X-Bunq-';
    const HEADER_PREFIX_START = 0;
    const HEADER_SEPARATOR = ', ';
    const FORMAT_HEADER = '%s: %s';
    const HEADER_NEWLINE = "\n";

    /**
     * Http status constants.
     */
    const STATUS_CODE_OK = 200;

    /**
     * Constants.
     */
    const RESULT_SIGNATURE_CORRECT = 1;
    const STRING_EMPTY = '';

    /**
     * @var PublicKey|null
     */
    protected $publicKeyServer;

    /**
     * ServerSignatureHandler constructor.
     *
     * @param PublicKey|null $publicKeyServer
     */
    public function __construct(PublicKey $publicKeyServer = null)
    {
        $this->publicKeyServer = $publicKeyServer;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws SecurityException
     */
    public function execute(ResponseInterface $response)
    {
        if ($response->getStatusCode() === self::STATUS_CODE_OK) {
            if (is_null($this->publicKeyServer)) {
                // No installation yet.
                return $response;
            } else {
                $toVerify =
                    $response->getStatusCode() .
                    self::HEADER_NEWLINE .
                    $this->determineHeaderStringForSignedResponse($response->getHeaders()) .
                    self::HEADER_NEWLINE . self::HEADER_NEWLINE .
                    $response->getBody()->getContents();

                $signature = base64_decode($response->getHeaderLine(self::HEADER_SERVER_SIGNATURE));
                $publicKey = $this->publicKeyServer->getKey();

                $signatureResult = openssl_verify($toVerify, $signature, $publicKey, OPENSSL_ALGO_SHA256);

                if ($signatureResult === self::RESULT_SIGNATURE_CORRECT) {
                    return $response;
                } else {
                    throw new SecurityException(self::ERROR_VERIFYING_RESPONSE_FAILED);
                }
            }
        } else {
            return $response;
        }
    }

    /**
     * @param string[][] $headers
     *
     * @return string
     */
    private function determineHeaderStringForSignedResponse(array $headers)
    {
        $signedDataHeaders = [];
        ksort($headers);

        foreach ($headers as $headerName => $headerValue) {
            // All headers with the prefix 'X-Bunq-' except 'Server-Signature' need to be signed.
            if ($headerName === self::HEADER_SERVER_SIGNATURE) {
                // Skip this header
            } elseif (strpos($headerName, self::HEADER_PREFIX) === self::HEADER_PREFIX_START) {
                $signedDataHeaders[] = $this->determineHeaderStringLine($headerName, $headerValue);
            }
        }

        return implode(self::HEADER_NEWLINE, $signedDataHeaders);
    }

    /**
     * @param string $headerName
     * @param string[] $headerValue
     *
     * @return string
     */
    private function determineHeaderStringLine($headerName, array $headerValue)
    {
        return vsprintf(self::FORMAT_HEADER, [$headerName, implode(self::HEADER_SEPARATOR, $headerValue)]);
    }
}
