<?php

namespace common\components;

use Picqer\Financials\Exact\Connection;
use Picqer\Financials\Exact\SubscriptionLine;
use Picqer\Financials\Exact\SyncSalesInvoice;

class ExactOnline
{
    public $testing = false;
    private Connection $connection;

    public function __construct(bool $testing = false)
    {
        $this->testing = $testing;
    }

    private function connectToExact(): void
    {
        $this->connection = new Connection();
        $this->connection->setRedirectUrl('CALLBACK_URL');
        $this->connection->setExactClientId('CLIENT_ID');
        $this->connection->setExactClientSecret('CLIENT_SECRET');
        $this->connection->setDivision('12312312');

        /*SETTING FAKE CODES*/
        /*We set some fake access and refresh to 2026 so we are "authenticated"*/
        $this->connection->setAuthorizationCode('AUTHORIZATION_CODE');
        $this->connection->setAccessToken('ACCESS_TOKEN');
        $this->connection->setRefreshToken('REFRESH_TOKEN');
        $this->connection->setTokenExpires(1788370830);

        // Make the client connect and exchange tokens
        try {
            $this->connection->connect();
            codecept_debug('Connected to Exact');
        } catch (\Exception $e) {
            throw new \RuntimeException('Could not connect to Exact: ' . $e->getMessage());
        }
    }

    public function getSubscriptionLinesAsGenerator(): void
    {
        $this->connectToExact();

        $item = new SubscriptionLine($this->connection);
        $item->filterAsGenerator('', '', 'ID');
        $item->filterAsGenerator('', '', 'ID');

    }

    public function getSubscription(): void
    {
        $this->connectToExact();

        $item = new SubscriptionLine($this->connection);
        $item->get();
    }


}
