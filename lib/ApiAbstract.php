<?php

declare(strict_types=1);

namespace BeGateway;

use Exception;

abstract class ApiAbstract
{
    abstract protected function _buildRequestMessage(): array;

    protected $_language;
    protected $_timeout_connect = 10;
    protected $_timeout_read = 30;
    protected $_headers = [];

    public function submit()
    {
        try {
            $response = $this->_remoteRequest();
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $response = '{"errors":"' . $msg . '","message":"' . $msg . '"}';
        }

        return new Response($response);
    }

    protected function _remoteRequest()
    {
        return GatewayTransport::submit(
            $this->_endpoint(),
            $this->_buildRequestMessage(),
            $this->_headers,
            $this->_timeout_read,
            $this->_timeout_connect
        );
    }

    protected function _endpoint(): string
    {
        return Settings::$gatewayBase . '/transactions/' . $this->_getTransactionType();
    }

    protected function _getTransactionType()
    {
        [$module, $klass] = explode('\\', get_class($this));
        $klass = str_replace('Operation', '', $klass);

        return strtolower($klass) . 's';
    }

    public function setLanguage($language_code): void
    {
        if (in_array($language_code, Language::getSupportedLanguages())) {
            $this->_language = $language_code;
        } else {
            $this->_language = Language::getDefaultLanguage();
        }
    }

    public function getLanguage()
    {
        return $this->_language;
    }

    public function setConnectTimeout($timeout): void
    {
        $this->_timeout_connect = $timeout;
    }

    public function setTimeout($timeout): void
    {
        $this->_timeout_read = $timeout;
    }

    public function setRequestHeaders($headers): void
    {
        $this->_headers = $headers;
    }
}
