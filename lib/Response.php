<?php

namespace BeGateway;

class Response extends ResponseBase
{
    public function isSuccess(): bool
    {
        return $this->getStatus() == 'successful';
    }

    public function isFailed(): bool
    {
        return $this->getStatus() == 'failed';
    }

    public function isIncomplete(): bool
    {
        return $this->getStatus() == 'incomplete';
    }

    public function isPending(): bool
    {
        return $this->getStatus() == 'pending';
    }

    public function isTest(): bool
    {
        if ($this->hasTransactionSection()) {
            return $this->getResponse()->transaction->test == true;
        }

        return false;
    }

    public function getStatus()
    {
        if ($this->hasTransactionSection()) {
            return $this->getResponse()->transaction->status;
        }

        if ($this->isError()) {
            return 'error';
        }

        return false;
    }

    public function getUid()
    {
        if ($this->hasTransactionSection()) {
            return $this->getResponse()->transaction->uid;
        }

        return false;
    }

    public function getTrackingId()
    {
        if ($this->hasTransactionSection()) {
            return $this->getResponse()->transaction->tracking_id;
        }

        return false;
    }

    public function getPaymentMethod()
    {
        if ($this->hasTransactionSection()) {
            return $this->getResponse()->transaction->payment_method_type;
        }

        return false;
    }

    public function hasTransactionSection(): bool
    {
        return is_object($this->getResponse()) && isset($this->getResponse()->transaction);
    }

    public function getMessage()
    {
        if (is_object($this->getResponse())) {
            if (isset($this->getResponse()->message)) {
                return $this->getResponse()->message;
            }

            if (isset($this->getResponse()->transaction)) {
                return $this->getResponse()->transaction->message;
            }

            if (isset($this->getResponse()->response)) {
                return $this->getResponse()->response->message;
            }
        }

        return '';
    }
}
