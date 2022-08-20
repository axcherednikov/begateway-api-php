<?php

namespace BeGateway;

class ResponseCheckout extends ResponseBase
{
    public function isSuccess(): bool
    {
        return isset($this->getResponse()->checkout);
    }

    public function isError(): bool
    {
        $error = parent::isError();

        if (isset($this->getResponse()->checkout) && isset($this->getResponse()->checkout->status)) {
            $error = $error || $this->getResponse()->checkout->status == 'error';
        }

        return $error;
    }

    public function getMessage(): string
    {
        if (isset($this->getResponse()->message)) {
            return $this->getResponse()->message;
        }

        if (isset($this->getResponse()->response) && isset($this->getResponse()->response->message)) {
            return $this->getResponse()->response->message;
        }

        if ($this->isError()) {
            return $this->_compileErrors();
        }

        return '';
    }

    public function getToken(): string
    {
        return $this->getResponse()->checkout->token;
    }

    public function getRedirectUrl(): string
    {
        return $this->getResponse()->checkout->redirect_url;
    }

    public function getRedirectUrlScriptName()
    {
        return preg_replace('/(.+)\?token=(.+)/', '$1', $this->getRedirectUrl());
    }

    private function _compileErrors(): string
    {
        $message = 'there are errors in request parameters.';

        if (isset($this->getResponse()->errors)) {
            foreach ($this->getResponse()->errors as $name => $desc) {
                $message .= ' ' . print_r($name, true);

                foreach ($desc as $value) {
                    $message .= ' ' . $value . '.';
                }
            }
        } elseif (isset($this->getResponse()->checkout->message)) {
            $message = $this->getResponse()->checkout->message;
        }

        return $message;
    }
}
