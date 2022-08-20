<?php

namespace BeGateway;

class QueryByPaymentToken extends ApiAbstract
{
    protected $_token;

    protected function _endpoint(): string
    {
        return Settings::$checkoutBase . '/ctp/api/checkouts/' . $this->getToken();
    }

    public function setToken($token): void
    {
        $this->_token = $token;
    }

    public function getToken()
    {
        return $this->_token;
    }

    protected function _buildRequestMessage(): array
    {
        return [];
    }

    public function submit()
    {
        return new ResponseCheckout($this->_remoteRequest());
    }
}
