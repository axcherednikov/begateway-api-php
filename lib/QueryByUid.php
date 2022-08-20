<?php

namespace BeGateway;

class QueryByUid extends ApiAbstract
{
    protected $_uid;
    protected $_current_endpoint;

    public function submit()
    {
        $response = null;

        foreach ($this->_endpoints() as $_endpoint) {
            $this->_current_endpoint = $_endpoint;

            try {
                $response = $this->_remoteRequest();
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                $response = '{ "errors":"' . $msg . '", "message":"' . $msg . '" }';
            }

            $response = new Response($response);

            if ($response->getUid()) {
                break;
            }
        }

        return $response;
    }

    protected function _endpoint(): string
    {
        return $this->_current_endpoint;
    }

    public function setUid($uid): void
    {
        $this->_uid = $uid;
    }

    public function getUid()
    {
        return $this->_uid;
    }

    protected function _buildRequestMessage(): array
    {
        return [];
    }

    protected function _endpoints()
    {
        return [
            Settings::$apiBase . '/beyag/payments/' . $this->getUid(),
            Settings::$apiBase . '/beyag/transactions/' . $this->getUid(),
            Settings::$gatewayBase . '/transactions/' . $this->getUid(),
        ];
    }
}
