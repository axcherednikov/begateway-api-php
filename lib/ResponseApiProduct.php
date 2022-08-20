<?php

declare(strict_types=1);

namespace BeGateway;

class ResponseApiProduct extends ResponseApi
{
    public function getPayLink(): string
    {
        return implode(
            '/',
            [
                Settings::$checkoutBase,
                'v2',
                'confirm_order',
                $this->getId(),
                Settings::$shopId,
            ]
        );
    }

    public function getPayUrl(): string
    {
        return implode(
            '/',
            [
                Settings::$apiBase,
                'products',
                $this->getId(),
                'pay',
            ]
        );
    }
}
