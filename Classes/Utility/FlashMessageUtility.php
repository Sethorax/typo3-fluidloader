<?php

namespace Sethorax\Fluidloader\Utility;

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class FlashMessageUtility.
 */
class FlashMessageUtility
{
    /**
     * Adds a flash message with type NOTICE.
     *
     * @param string $message
     * @param string $header
     */
    public static function showNotice($message, $header)
    {
        self::addFlashMessage($message, $header, FlashMessage::NOTICE);
    }

    /**
     * Adds a flash message with type INFO.
     *
     * @param string $message
     * @param string $header
     */
    public static function showInfo($message, $header)
    {
        self::addFlashMessage($message, $header, FlashMessage::INFO);
    }

    /**
     * Adds a flash message with type OK.
     *
     * @param string $message
     * @param string $header
     */
    public static function showOK($message, $header)
    {
        self::addFlashMessage($message, $header, FlashMessage::OK);
    }

    /**
     * Adds a flash message with type WARNING.
     *
     * @param string $message
     * @param string $header
     */
    public static function showWarning($message, $header)
    {
        self::addFlashMessage($message, $header, FlashMessage::WARNING);
    }

    /**
     * Adds a flash message with type ERROR.
     *
     * @param string $message
     * @param string $header
     */
    public static function showError($message, $header)
    {
        self::addFlashMessage($message, $header, FlashMessage::ERROR);
    }

    /**
     * Creates the actual flash message and adds it to the queue.
     *
     * @param string $message
     * @param string $header
     * @param string $type
     */
    protected static function addFlashMessage($message, $header, $type)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $flashMessageService = $objectManager->get(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();

        $flashMessage = GeneralUtility::makeInstance(FlashMessage::class,
            $message,
            $header,
            $type
        );

        $messageQueue->addMessage($flashMessage);
    }
}
