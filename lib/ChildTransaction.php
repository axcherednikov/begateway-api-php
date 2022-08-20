<?php

namespace BeGateway;

abstract class ChildTransaction extends ApiAbstract
{
    protected $_parent_uid;
    public $money;

    public function __construct()
    {
        $this->money = new Money();
    }

    public function setParentUid($uid): void
    {
        $this->_parent_uid = $uid;
    }

    public function getParentUid()
    {
        return $this->_parent_uid;
    }

    protected function _buildRequestMessage(): array
    {
        $request = [
            'request' => [
                'parent_uid' => $this->getParentUid(),
                'amount' => $this->money->getCents(),
            ],
        ];

        Logger::getInstance()->write($request, Logger::DEBUG, get_class() . '::' . __FUNCTION__);

        return $request;
    }
}
