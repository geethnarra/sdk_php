<?php
namespace bunq\Model\Generated\Object;

use bunq\Model\BunqModel;

/**
 * @generated
 */
class Error extends BunqModel
{
    /**
     * The error description (in English).
     *
     * @var string
     */
    protected $errorDescription;

    /**
     * The error description (in the user language).
     *
     * @var string
     */
    protected $errorDescriptionTranslated;

    /**
     * The error description (in English).
     *
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    /**
     * @param string $errorDescription
     */
    public function setErrorDescription($errorDescription)
    {
        $this->errorDescription = $errorDescription;
    }

    /**
     * The error description (in the user language).
     *
     * @return string
     */
    public function getErrorDescriptionTranslated()
    {
        return $this->errorDescriptionTranslated;
    }

    /**
     * @param string $errorDescriptionTranslated
     */
    public function setErrorDescriptionTranslated($errorDescriptionTranslated)
    {
        $this->errorDescriptionTranslated = $errorDescriptionTranslated;
    }
}
