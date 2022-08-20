<?php

namespace BeGateway;

class RefundOperation extends ChildTransaction
{
    protected $_reason;

    public function setReason($reason): void
    {
        $this->_reason = $reason;
    }

    public function getReason()
    {
        return $this->_reason;
    }

    protected function _buildRequestMessage(): array
    {
        $request = parent::_buildRequestMessage();

        $request['request']['reason'] = $this->getReason();

        return $request;
    }
}
